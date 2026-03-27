import AppKit
import Foundation

enum RasterizeError: Error {
    case usage
    case loadFailed
    case bitmapCreationFailed
    case jpegEncodingFailed
}

do {
    let args = CommandLine.arguments
    guard args.count == 3 else {
        throw RasterizeError.usage
    }

    let inputURL = URL(fileURLWithPath: args[1])
    let outputURL = URL(fileURLWithPath: args[2])

    guard let image = NSImage(contentsOf: inputURL) else {
        throw RasterizeError.loadFailed
    }

    let width = Int(image.size.width)
    let height = Int(image.size.height)

    guard let rep = NSBitmapImageRep(
        bitmapDataPlanes: nil,
        pixelsWide: width,
        pixelsHigh: height,
        bitsPerSample: 8,
        samplesPerPixel: 4,
        hasAlpha: true,
        isPlanar: false,
        colorSpaceName: .deviceRGB,
        bytesPerRow: 0,
        bitsPerPixel: 0
    ) else {
        throw RasterizeError.bitmapCreationFailed
    }

    rep.size = image.size

    NSGraphicsContext.saveGraphicsState()
    let context = NSGraphicsContext(bitmapImageRep: rep)
    NSGraphicsContext.current = context
    NSColor.white.setFill()
    NSBezierPath(rect: NSRect(x: 0, y: 0, width: width, height: height)).fill()
    image.draw(
        in: NSRect(x: 0, y: 0, width: width, height: height),
        from: .zero,
        operation: .sourceOver,
        fraction: 1.0
    )
    NSGraphicsContext.restoreGraphicsState()

    guard let data = rep.representation(using: .jpeg, properties: [.compressionFactor: 0.92]) else {
        throw RasterizeError.jpegEncodingFailed
    }

    try data.write(to: outputURL)
} catch RasterizeError.usage {
    fputs("Usage: swift tools/rasterize_svg_to_jpg.swift <input.svg> <output.jpg>\n", stderr)
    exit(64)
} catch {
    fputs("rasterize_svg_to_jpg failed: \(error)\n", stderr)
    exit(1)
}
