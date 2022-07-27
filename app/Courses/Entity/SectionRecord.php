<?php

namespace app\Courses\Entity;

class SectionRecord
{
    public int $sectionId;
    public string $type;
    public mixed $content;

    public function __construct(string $type,mixed $content)
    {
        $this->sectionId = time() + rand(100,999) - 1658900000;
        $this->type = $type;
        $this->content = $content;
    }

    public function getSectionId(): int
    {
        return $this->sectionId;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getType()
    {
        return $this->type;
    }

//    public function __toString(): string
//    {
//        return "";
//        //rewrite
////        return ("<td>" . $this->courseId . "</td>" .
////            "<td>" . $this->title . "</td>" .
////            "<td>" . $this->authorName . "</td>" .
////            "<td>" . $this->content . "</td>" .
////            "<td>" . $this->deletedAt . "</td>"
////        );
//    }

}