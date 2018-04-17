<?php
namespace App\Service;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use JMS\Serializer\Context;
use JMS\Serializer\Exception\InvalidArgumentException;
use JMS\Serializer\GenericDeserializationVisitor;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\VisitorInterface;
use JMS\Serializer\GraphNavigator;
class EntityHandler implements SubscribingHandlerInterface
{
    /**
     * @var RegistryInterface
     */
    protected $registry;
    /**
     * @return array
     */
    public static function getSubscribingMethods()
    {
        $methods = [];
        foreach (['json', 'xml', 'yml'] as $format) {
            $methods[] = [
                'type' => 'Entity',
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format' => $format,
                'method' => 'deserializeEntity',
            ];
            $methods[] = [
                'type' => 'Entity',
                'format' => $format,
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'method' => 'serializeEntity',
            ];
        }
        return $methods;
    }
    /**
     * EntityHandler constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        $this->registry = $registry;
    }
    /**
     * @param VisitorInterface $visitor
     * @param $entity
     * @param array $type
     * @param Context $context
     * @return mixed
     */
    public function serializeEntity(VisitorInterface $visitor, $entity, array $type, Context $context)
    {
        $entityClass = $this->getEntityClassFromParameters($type['params']);
        if (!$entity instanceof  $entityClass) {
            throw new InvalidArgumentException(
                sprintf("Entity class '%s' was expected, but '%s' got", $entityClass, get_class($entity))
            );
        }
        $entityManager = $this->getEntityManager($entityClass);
        $primaryKeyValues = $entityManager->getClassMetadata($entityClass)->getIdentifierValues($entity);
        if (count($primaryKeyValues) > 1) {
            throw new InvalidArgumentException(
                sprintf("Composite primary keys does'nt supported now (found in class '%s')", $entityClass)
            );
        }
        if (!count($primaryKeyValues)) {
            throw new InvalidArgumentException(
                sprintf("No primary keys found for entity '%s')", $entityClass)
            );
        }
        $id = array_shift($primaryKeyValues);
        if (is_int($id) || is_string($id)) {
            return $visitor->visitString($id, $type, $context);
        } else {
            throw new InvalidArgumentException(
                sprintf(
                    "Invalid primary key type for entity '%s' (only integer or string are supported",
                    $entityClass
                )
            );
        }
    }
    /**
     * @param GenericDeserializationVisitor $visitor
     * @param string $id
     * @param array $type
     * @return null|object
     */
    public function deserializeEntity(GenericDeserializationVisitor $visitor, $id, array $type)
    {
        if (null === $id) {
            return null;
        }
        if (!(is_array($type) && isset($type['params']) && is_array($type['params']) && isset($type['params']['0']))) {
            return null;
        }
        $entityClass = $type['params'][0]['name'];
        $entityManager = $this->getEntityManager($entityClass);
        return $entityManager->getRepository($entityClass)->find($id);
    }
    /**
     * @param array $parameters
     * @return string
     */
    protected function getEntityClassFromParameters(array $parameters)
    {
        if (!(isset($parameters[0]) && is_array($parameters[0]) && isset($parameters[0]['name']))) {
            throw new InvalidArgumentException('Entity class is not defined');
        }
        if (!class_exists($parameters[0]['name'])) {
            throw new InvalidArgumentException(sprintf("Entity class '%s' is not found", $parameters[0]['name']));
        }
        return $parameters[0]['name'];
    }
    /**
     * @param string $entityClass
     * @return EntityManagerInterface
     */
    protected function getEntityManager($entityClass)
    {
        $entityManager = $this->registry->getEntityManagerForClass($entityClass);
        if (!$entityManager) {
            throw new InvalidArgumentException(
                sprintf("Entity class '%s' is not mannaged by Doctrine", $entityClass)
            );
        }
        return $entityManager;
    }
}
