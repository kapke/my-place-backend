<?php
namespace Kapke\Provider\Notes;

class NotesManager
{
    private $orm;
    private $notesRepo;

    public function __construct($doctrine)
    {
        $this->orm = $doctrine->getManager();
    }

    public function getNotes()
    {
    }
}
