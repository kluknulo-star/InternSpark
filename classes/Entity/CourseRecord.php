<?php

class CourseRecord {

    //добавить roles
    private int $courseId;
    private $authorId;
    private string $authorName;
    private string $title;
    private $content;
    private  $deletedAt;

    public function __construct($courseId, $authorId, $title, $authorName, $content, $deletedAt){
        $this->courseId = $courseId;
        $this->title = $title;
        $this->authorName = $authorName;
        $this->authorId = $authorId;
        $this->content = $content;
        $this->deletedAt = $deletedAt;
    }

    public function getIdCourse() : int
    {
        return $this->courseId;
    }

    public function getIdAuthor() : int
    {
        return $this->authorId;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function isDeleted()
    {
        return $this->deletedAt;
    }

    public function getAuthorName()
    {
        return $this->authorName;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function __toString(): string
    {
        return ("<td>" . $this->courseId . "</td>" .
            "<td>" . $this->title . "</td>" .
            "<td>" . $this->authorName . "</td>" .
            "<td>" . $this->content . "</td>" .
            "<td>" . $this->deletedAt . "</td>"
        );
    }

    public function userToString(): string
    {
        return ("<td>" . $this->courseId . "</td>" .
            "<td>" . $this->title . "</td>" .
            "<td>" . $this->authorName . "</td>" .
            "<td>" . $this->content . "</td>"
        );
    }
}
?>