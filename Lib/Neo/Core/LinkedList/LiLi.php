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
/// LiLi is a linked list element implementation that allows you to make any class linkable.
///
/// It keeps track of the previous and next element.
///
/// Note that the head and tail are not explicitely stored (no static property) which means that the methods
/// head() and tail() below run in O(n) as they have to loop through the whole list.
/// If you need these methods a lot, you should consider coding a list class that wraps all these elements
/// and keeps track of the head and tail as a static class property, which would then run in O(1).
/// Idem for count() which runs in O(n) by going through the whole list in both directions
/// starting at a certain position.
///
trait LiLi {

    ///
    /// Link this element into a list using an existing element as reference position.
    ///
    /// $position : A valid element of the list you want to join.
    /// It's possible to link this element to another position in its own list.
    ///
    /// $above : If true, this element goes above the reference position. By default, it goes below.
    ///
    public function link($position, $above = false)
    {
        if (!$this->is_head()) $this->prev->next = $this->next;
        if (!$this->is_tail()) $this->next->prev =  $this->prev;
        if ($above) {
            // [prev]
            // [*]
            // [position]
            if (!$position->is_head()) $position->prev->next = $this;
            $this->prev = $position->prev;
            $this->next = $position;
            $position->prev = $this;
        }
        else {
            // [position]
            // [*]
            // [next]
            if (!$position->is_tail()) $position->next->prev = $this;
            $this->next = $position->next;
            $this->prev = $position;
            $position->next = $this;
        }
    }

    ///
    /// Append or prepend this element to a list using an arbitrary existing reference element.
    ///
    /// $list : A valid element of the list you want to join.
    /// It's possible to bubble this element to the head or tail of its own list by passing null here.
    ///
    /// $as_head : If true, this element becomes the head of the list. By default, it becomes the tail.
    ///
    public function bubble($list = null, $as_head = false)
    {
        if ($list === null) $list = $this;
        if ($as_head) {
            // [null]
            // [*]
            // [head]
            $head = $list->head();
            $this->destroy();
            $head->prev = $this;
            $this->prev = null;
            $this->next = $head;
        }
        else {
            // [tail]
            // [*]
            // [null]
            $tail = $list->tail();
            $this->destroy();
            $tail->next = $this;
            $this->next = null;
            $this->prev = $tail;
        }
    }

    ///
    /// Swap two elements of the same list.
    ///
    /// $with : A valid list element you want to swap with.
    ///
    public function swap($with)
    {
        if (!$this->is_head()) $this->prev->next = $with;
        if (!$this->is_tail()) $this->next->prev = $with;
        if (!$with->is_head()) $with->prev->next = $this;
        if (!$with->is_tail()) $with->next->prev = $this;
        $prev = $this->prev;
        $next = $this->next;
        $this->prev = $with->prev;
        $this->next = $with->next;
        $with->prev = $prev;
        $with->next = $next;
    }

    ///
    /// Get or set next list element.
    ///
    public function next($next = false)
    {
        if ($next === false) return $this->next;
        $this->next = $next;
    }

    ///
    /// Get or set previous list element.
    ///
    public function prev($prev = false)
    {
        if ($prev === false) return $this->prev;
        $this->prev = $prev;
    }

    ///
    /// Rewind and return first list element.
    ///
    public function head()
    {
        for ($i = $this; $i->prev !== null; $i = $i->prev);
        return $i;
    }

    ///
    /// Fast-forward and return last list element.
    ///
    public function tail()
    {
        for ($i = $this; $i->next !== null; $i = $i->next);
        return $i;
    }

    ///
    /// Merge all list elements together and return a complete and sorted array.
    ///
    public function merge()
    {
        for ($i = $this->head(), $j = array(); $i !== null; $i = $i->next) $j[] = $i;
        return $j;
    }

    ///
    /// Destroy the current list element by joining ends and isolating this element.
    ///
    public function destroy()
    {
        if (!$this->is_head()) $this->prev->next = $this->next;
        if (!$this->is_tail()) $this->next->prev = $this->prev;
        $this->prev = $this->next = null;
    }

    ///
    /// Count the number of elements in the linked list.
    ///
    public function count()
    {
        for ($i = $this, $j = 1; $i->prev !== null; $i = $i->prev, $j++);
        for ($i = $this; $i->next !== null; $i = $i->next, $j++);
        return $j;
    }

    ///
    /// Return true if this is the first element of the linked list and false otherwise.
    ///
    public function is_head()
    {
        return $this->prev === null;
    }

    ///
    /// Return true if this is the last element of the linked list and false otherwise.
    ///
    public function is_tail()
    {
        return $this->next === null;
    }

    ///
    /// The next element of the linked list
    ///
    protected $next = null;

    ///
    /// The previous element of the linked list
    ///
    protected $prev = null;

}
