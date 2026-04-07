<?php
                                                                                                                                                                                                                                                                                                                                                                                
namespace Drupal\footer_block\Plugin\Block; 

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;                                                                                                                                           
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;                                                                                                                                     
                
/**
 * @Block(
 *   id = "footer_block",                                                                                                                                                                         
 *   admin_label = @Translation("Footer block"),
 * )                                                                                                                                                                                              
 */             
class FooterBlock extends BlockBase implements ContainerFactoryPluginInterface {
                                                                                                                                                                                                
// Guarda o serviço injetado para usar no build()                                                                                                                                               
public function __construct(                                                                                                                                                                    
    array $configuration,                                                                                                                                                                         
    $plugin_id, 
    $plugin_definition,
    protected EntityTypeManagerInterface $entityTypeManager,
) {                                                                                                                                                                                             
    // Obrigatório — inicializa o plugin base
    parent::__construct($configuration, $plugin_id, $plugin_definition);                                                                                                                          
}             
                                                                                                                                                                                                
// Drupal chama este método para montar a instância com os serviços certos                                                                                                                      
public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): static {
    return new static(                                                                                                                                                                            
    $configuration,
    $plugin_id,                                                                                                                                                                                 
    $plugin_definition,
    $container->get('entity_type.manager'), // injeta o serviço
    );                                                                                                                                                                                            
}
                                                                                                                                                                                                
public function build(): array {
    // Busca o node do tipo footer publicado
    $nodes = $this->entityTypeManager
    ->getStorage('node')                                                                                                                                                                        
    ->loadByProperties([
        'type'   => 'footer',                                                                                                                                                                     
        'status' => NodeInterface::PUBLISHED,
    ]);

    if (empty($nodes)) {                                                                                                                                                                          
    return [];
    }                                                                                                                                                                                             
                
    $node = reset($nodes); // pega o primeiro (só deve existir um)                                                                                                                                

    // Renderiza o node — isso dispara o node--footer.html.twig                                                                                                                                   
    return $this->entityTypeManager
    ->getViewBuilder('node')                                                                                                                                                                    
    ->view($node, 'full');
}                                                                                                                                                                                               

}                            