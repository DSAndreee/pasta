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
/// Markers trait allows you to use generic linked list markers in a class.
///
/// Note: This trait uses Error.
///
trait Markers {

    ///
    /// Add a new marker.
    ///
    /// Makes sure that $id is not empty and not already taken; $position is a valid marker id;
    /// Adds a new constructed marker object (Neo\Marker) to the assoc array
    /// that contains all defined markers ($this->markers).
    ///
    /// $above controls if the new marker should go above or below the $position marker.
    ///
    /// Return $this instance for fluent coding.
    ///
    public function add_marker($marker, $position = 'default', $above = false)
    {
        if (isset($this->markers[$marker=(string)$marker])) return $this->handle_error(sprintf('%s() : ID already taken.', __METHOD__));
        if (!isset($this->markers[$position])) return $this->handle_error(sprintf('%s() : Position marker doesn\'t exist.', __METHOD__));

        $this->markers[$marker] = new Marker($marker, $this->markers[$position], $above);

        return $this;
    }

    ///
    /// Destroy an existing marker.
    ///
    /// Makes sure that $id is not empty and that the marker exists.
    ///
    /// Note that you can't delete 'default': if you try to do so, you will only
    /// clear its content without removing the marker itself.
    ///
    /// Return $this instance for fluent coding.
    ///
    public function destroy_marker($marker)
    {
        if (!isset($this->markers[$marker=(string)$marker])) return $this->handle_error(sprintf('%s() : No such marker.', __METHOD__));

        if ($marker === 'default') {
            $this->markers[$marker]->clear();
        }
        else {
            $this->markers[$marker]->destroy();
            unset($this->markers[$marker]);
        }

        return $this;
    }

    ///
    /// Initialize default marker element which id is 'default'.
    ///
    protected function init_default_marker()
    {
        $this->markers['default'] = new Marker('default');
    }

    ///
    /// Initialize custom markers in the constructor.
    /// Overload this, if you wish to define custom markers in the constructor.
    ///
    protected function init_markers() {}

    ///
    /// Append data to an existing marker.
    ///
    /// Makes sure that $marker is a valid marker id.
    ///
    /// Return $this instance for fluent coding.
    ///
    protected function append_data($data, $marker = 'default')
    {
        if (!isset($this->markers[$marker=(string)$marker])) return $this->handle_error(sprintf('%s() : Position marker doesn\'t exist.', __METHOD__));

        $this->markers[$marker]->append($data);

        return $this;
    }

    ///
    /// Prepend data to an existing marker.
    ///
    /// Makes sure that $marker is a valid marker id.
    ///
    /// Return $this instance for fluent coding.
    ///
    protected function prepend_data($data, $marker = 'default')
    {
        if (!isset($this->markers[$marker=(string)$marker])) return $this->handle_error(sprintf('%s() : Position marker doesn\'t exist.', __METHOD__));

        $this->markers[$marker]->prepend($data);

        return $this;
    }

    ///
    /// Assoc array of markers
    ///
    protected $markers;

}
