import AppKit
import Foundation

enum ExportError: Error {
    case usage
    case loadFailed
    case cgImageUnavailable
    case contextCreationFailed
    case outputEncodingFailed
    case noVisiblePixels
}

let bytesPerPixel = 4
let bitsPerComponent = 8
let whiteThreshold: UInt8 = 250
let alphaThreshold: UInt8 = 10
let padding = 2

func rgbaContext(width: Int, height: Int) throws -> CGContext {
    guard let colorSpace = CGColorSpace(name: CGColorSpace.sRGB),
          let context = CGContext(
            data: nil,
            width: width,
            height: height,
            bitsPerComponent: bitsPerComponent,
            bytesPerRow: width * bytesPerPixel,
            space: colorSpace,
            bitmapInfo: CGImageAlphaInfo.premultipliedLast.rawValue
          ) else {
        throw ExportError.contextCreationFailed
    }
    return context
}

func loadPixels(from cgImage: CGImage) throws -> (CGContext, UnsafeMutablePointer<UInt8>) {
    let context = try rgbaContext(width: cgImage.width, height: cgImage.height)
    let rect = CGRect(x: 0, y: 0, width: cgImage.width, height: cgImage.height)
    context.draw(cgImage, in: rect)

    guard let data = context.data else {
        throw ExportError.contextCreationFailed
    }

    return (context, data.bindMemory(to: UInt8.self, capacity: cgImage.width * cgImage.height * bytesPerPixel))
}

func findBounds(width: Int, height: Int, pixels: UnsafeMutablePointer<UInt8>) throws -> CGRect {
    let bytesPerRow = width * bytesPerPixel
    var minX = width
    var minY = height
    var maxX = -1
    var maxY = -1

    for y in 0..<height {
        for x in 0..<width {
            let offset = y * bytesPerRow + x * bytesPerPixel
            let r = pixels[offset]
            let g = pixels[offset + 1]
            let b = pixels[offset + 2]
            let a = pixels[offset + 3]

            let isWhite = r >= whiteThreshold && g >= whiteThreshold && b >= whiteThreshold
            let isVisible = a > alphaThreshold && !isWhite
            if isVisible {
                minX = min(minX, x)
                minY = min(minY, y)
                maxX = max(maxX, x)
                maxY = max(maxY, y)
            }
        }
    }

    guard maxX >= minX, maxY >= minY else {
        throw ExportError.noVisiblePixels
    }

    let x = max(minX - padding, 0)
    let y = max(minY - padding, 0)
    let width = min((maxX - minX + 1) + (padding * 2), Int.max)
    let height = min((maxY - minY + 1) + (padding * 2), Int.max)

    return CGRect(x: x, y: y, width: width, height: height)
}

func makeTransparentCroppedImage(from cgImage: CGImage) throws -> CGImage {
    let (sourceContext, sourcePixels) = try loadPixels(from: cgImage)
    let bounds = try findBounds(width: cgImage.width, height: cgImage.height, pixels: sourcePixels)

    let cropX = Int(bounds.origin.x)
    let cropY = Int(bounds.origin.y)
    let cropWidth = Int(bounds.width)
    let cropHeight = Int(bounds.height)

    let outputContext = try rgbaContext(width: cropWidth, height: cropHeight)
    guard let outputData = outputContext.data else {
        throw ExportError.contextCreationFailed
    }

    let outputPixels = outputData.bindMemory(to: UInt8.self, capacity: cropWidth * cropHeight * bytesPerPixel)
    let sourceBytesPerRow = cgImage.width * bytesPerPixel
    let outputBytesPerRow = cropWidth * bytesPerPixel

    for y in 0..<cropHeight {
        for x in 0..<cropWidth {
            let sourceOffset = (cropY + y) * sourceBytesPerRow + (cropX + x) * bytesPerPixel
            let outputOffset = y * outputBytesPerRow + x * bytesPerPixel

            let r = sourcePixels[sourceOffset]
            let g = sourcePixels[sourceOffset + 1]
            let b = sourcePixels[sourceOffset + 2]
            var a = sourcePixels[sourceOffset + 3]

            let isWhite = r >= whiteThreshold && g >= whiteThreshold && b >= whiteThreshold
            if isWhite {
                a = 0
            }

            outputPixels[outputOffset] = r
            outputPixels[outputOffset + 1] = g
            outputPixels[outputOffset + 2] = b
            outputPixels[outputOffset + 3] = a
        }
    }

    guard let outputImage = outputContext.makeImage() else {
        throw ExportError.contextCreationFailed
    }

    _ = sourceContext
    return outputImage
}

func savePNG(_ cgImage: CGImage, to url: URL) throws {
    let rep = NSBitmapImageRep(cgImage: cgImage)
    guard let data = rep.representation(using: .png, properties: [:]) else {
        throw ExportError.outputEncodingFailed
    }
    try data.write(to: url)
}

do {
    let args = CommandLine.arguments
    guard args.count == 3 else {
        throw ExportError.usage
    }

    let inputURL = URL(fileURLWithPath: args[1])
    let outputURL = URL(fileURLWithPath: args[2])

    guard let image = NSImage(contentsOf: inputURL) else {
        throw ExportError.loadFailed
    }

    var proposedRect = CGRect.zero
    guard let cgImage = image.cgImage(forProposedRect: &proposedRect, context: nil, hints: nil) else {
        throw ExportError.cgImageUnavailable
    }

    let result = try makeTransparentCroppedImage(from: cgImage)
    try savePNG(result, to: outputURL)
} catch ExportError.usage {
    fputs("Usage: swift tools/transparent_trim_png.swift <input.png> <output.png>\n", stderr)
    exit(64)
} catch {
    fputs("transparent_trim_png failed: \(error)\n", stderr)
    exit(1)
}
