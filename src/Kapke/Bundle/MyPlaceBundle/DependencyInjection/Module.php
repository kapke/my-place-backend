<?php
namespace Kapke\Bundle\MyPlaceBundle\DependencyInjection;

class Module
{
    use Serializer;
    protected $serializableProperties;

    private $name;
    private $title;
    private $vendor;
    private $parent;
    private $children;

    public function __construct($moduleDef)
    {
        $this->children = [];
        $this->serializableProperties = [
            ['name' => 'name'],
            ['name' => 'title'],
            ['name' => 'vendor'],
            ['name' => 'children'],
            [
                'name' => 'slug',
                'value' => [$this, 'getSlug']
            ]
        ];
        $this->name = $moduleDef['name'];
        $this->title = $moduleDef['title'];
        $this->vendor = $moduleDef['vendor'];
        $this->parent = isset($moduleDef['parent']) ? $moduleDef['parent'] : null;
    }

    public function getSlug()
    {
        $slug = implode(
            array_map(
                function ($letter) {
                    if (ctype_upper($letter)) {
                        return '_'.strtolower($letter);
                    } else {
                        return $letter;
                    }
                },
                str_split($this->name)
            )
        );

        return substr($slug, 1);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getVendor()
    {
        return $this->vendor;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function hasParent()
    {
        return ($this->parent != null);
    }

    public function addChild(Module $child)
    {
        $this->children[] = $child;
    }

}
