<?php

namespace Drupal\create_rest_api\Plugin\rest\resource;

use Drupal\Core\Session\AccountProxyInterface;
use Drupal\node\Entity\Node;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Psr\Log\LoggerInterface;

/**
 * Provides a resource to get view modes by entity and bundle.
 *
 * @RestResource(
 *   id = "create_rest_api_resource",
 *   label = @Translation("This will create node via api"),
 *   serialization_class = "Drupal\node\Entity\Node",
 *   uri_paths = {
 *     "canonical" = "/create-api-node",
 *     "https://www.drupal.org/link-relations/create" = "/create-api-node"
 *   }
 * )
 */

class CreateRestApiNode extends ResourceBase {

    protected $currentUser;

    public function __construct(
        array $configuration,
        $plugin_id,
        $plugin_definition,
        array $serializer_formats,
        LoggerInterface $logger,
        AccountProxyInterface $current_user) {
        parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);

        $this->currentUser = $current_user;
    }

    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->getParameter('serializer.formats'),
            $container->get('logger.factory')->get('ccms_rest'),
            $container->get('current_user')
        );
    }

    public function post($node_type) {

        if (!$this->currentUser->hasPermission('access content')) {
            throw new AccessDeniedHttpException();
        }


        $node = Node::create(
            array(
                'type' => $node_type->type->target_id,
                'title' => $node_type->title->value,
                'body' => [
                    'summary' => '',
                    'value' => $node_type->body->value,
                    'format' => 'full_html',
                ],
                'field_tags' => $node_type->field_tags->target_id,
                'field_publish_date' => $node_type->field_publish_date->value
            )
        );

        if($node->save())
            $response = ['message' => 'Node created successfully'];
        else
            $response = ['message' => 'Failed to create the node'];

        return new ResourceResponse($response);

    }
}
?>