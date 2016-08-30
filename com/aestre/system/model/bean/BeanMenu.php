<?php

/**
 * Clase bean que referencia a la tabla de menu y menu privilegios
 *
 * @author ShadowDarkCat
 */
class BeanMenu {

    //<editor-fold defaultstate="collapsed" desc="Campos Clase">
    private $parentItem;
    private $childItems;
    private $id;
    private $link;
    private $leyenda;
    private $toolTip;
    private $target;
    private $image;

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Accesores">    
    public function getParentItem() {
        return $this->parentItem;
    }

    public function getChildItems() {
        return $this->childItems;
    }

    public function getId() {
        return $this->id;
    }

    public function getLink() {
        return $this->link;
    }

    public function getLeyenda() {
        return $this->leyenda;
    }

    public function getToolTip() {
        return $this->toolTip;
    }

    public function getTarget() {
        return $this->target;
    }

    public function getImage() {
        return $this->image;
    }

    public function setParentItem($parentItem) {
        $this->parentItem = $parentItem;
    }

    public function setChildItems($childItems) {
        $this->childItems = $childItems;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setLink($link) {
        $this->link = $link;
    }

    public function setLeyenda($leyenda) {
        $this->leyenda = $leyenda;
    }

    public function setToolTip($toolTip) {
        $this->toolTip = $toolTip;
    }

    public function setTarget($target) {
        $this->target = $target;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    //</editor-fold>
}
