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
/// Linkable is a simple linked list element interface that makes any class linkable.
///
interface Linkable {

    ///
    /// Link this element into a list using an existing element as position.
    ///
    public function link($position, $above = false);

    ///
    /// Append or prepend this element to a list using an arbitrary existing element of that list.
    ///
    public function bubble($list = null, $as_head = false);

    ///
    /// Swap two elements of the same list.
    ///
    public function swap($with);

    ///
    /// Get or set next element.
    ///
    public function next($next = false);

    ///
    /// Get or set previous element.
    ///
    public function prev($prev = false);

    ///
    /// Rewind and return first element.
    ///
    public function head();

    ///
    /// Fast-forward and return last element.
    ///
    public function tail();

    ///
    /// Return a complete and sorted array.
    ///
    public function merge();

    ///
    /// Destroy the current element.
    ///
    public function destroy();

    ///
    /// Count the number of elements in the linked list.
    ///
    public function count();

    ///
    /// Return true if this is the first element of the linked list and false otherwise.
    ///
    public function is_head();

    ///
    /// Return true if this is the last element of the linked list and false otherwise.
    ///
    public function is_tail();

}
