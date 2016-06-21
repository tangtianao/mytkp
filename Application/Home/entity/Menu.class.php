<?php
namespace Home\entity;

class Menu{
    
    public   $menuid; 
    public   $name; 
    public   $url; 
    public   $parentid; 
    public   $isshow;
    public   $shiti;
    private  $children;
      
      
      
      
      
      
      
      
      
      
      
      
      
    /**
     * @return $shiti
     */
    public function getShiti()
    {
        return $this->shiti;
    }

    /**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setShiti($shiti)
    {
        $this->shiti = $shiti;
    }

    /**
     * @return $children
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setChildren(array $children)
    {
        $this->children = $children;
    }

    /**
     * @return $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return $url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return $parentid
     */
    public function getParentid()
    {
        return $this->parentid;
    }

    /**
     * @return $isshow
     */
    public function getIsshow()
    {
        return $this->isshow;
    }

    /**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setParentid($parentid)
    {
        $this->parentid = $parentid;
    }

    /**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setIsshow($isshow)
    {
        $this->isshow = $isshow;
    }
    /**
     * @return $menuid
     */
    public function getMenuid()
    {
        return $this->menuid;
    }

    /**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setMenuid($menuid)
    {
        $this->menuid = $menuid;
    }

 
    
    
}

?>