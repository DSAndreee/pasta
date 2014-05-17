<?php
///////////////////////////////////////////////////
///                                              //
/// Neo                                          //
/// Framework                                    //
///                                              //
/// YouniS Bensalah <younis.bensalah@riseup.net> //
///                                              //
/// Released under the MIT License.              //
///                                              //
///////////////////////////////////////////////////


namespace Neo;


/// 
/// Marker allows linking heterogen data elements and appending or prepending data at any position.
/// 
/// The inner data structure of Marker is basically a linked list where each element is a marker
/// that has an id and a data property which is an array.
///
/// Note that for the sake of performance we don't check if the marker id is really unique.
/// If you want to explicitely check this, you may use the seek() method and compare the returned value to null.
///
class Marker implements Linkable {

    use LiLi;

    use Error;

    ///
    /// Construct a new marker with an id string and insert it below (or above) an element
    /// or as new head (or tail) of the linked list.
    /// (See Neo\LiLi trait documentation for more information.)
    ///
    public function __construct($id, Linkable $position = null, $above = false)
    {
        $this->id = $id;
        $this->data = array();
        // insert into linked list
        if ($position !== null) $this->link($position, (bool)$above);
    }

    ///
    /// Append data to current marker.
    ///
    public function append($data)
    {
        $this->data[] = $data;
    }

    ///
    /// Prepend data to current marker.
    ///
    public function prepend($data)
    {
        array_unshift($this->data, $data);
    }

    ///
    /// Get data assoc array.
    ///
    public function get_data()
    {
        return $this->data;
    }

    ///
    /// Get/set id.
    ///
    public function id($id = false)
    {
        if ($id === false) return $this->id;
        $this->id = $id;
    }

    ///
    /// Seek and return a marker by id. If none was found, null is returned.
    ///
    public function seek($id)
    {
        // rewind, seek, and return
        for ($i = $this->head(); ($i !== null) && ($i->id !== $id); $i = $i->next);
        return $i;
    }

    ///
    /// Clear all data.
    ///
    public function clear_data()
    {
        $this->data = array();
    }

    ///
    /// Marker id
    ///
    protected $id;

    ///
    /// Data assoc array
    ///
    protected $data;

} 
