<?php
/**
 * Created by PhpStorm.
 * User: krsnaa
 * Date: 3/9/16
 * Time: 5:09 PM
 */

namespace Sitepoint;


class Comment
{
    protected $database;

    protected $name;
    protected $email;
    protected $comment;
    protected $submissionDate;

    public function __construct(\medoo $medoo)
    {
        $this->database = $medoo;
    }

    public function findAll()
    {
        $collection = [];
        $comments = $this->database->select('comments', '*', ['ORDER' => 'comments.submissionDate DESC']);
        if ($comments) {
            foreach ($comments as $array) {
                $comment = new self($this->database);
                $collection[] = $comment
                    ->setComment($array['comment'])
                    ->setEmail($array['email'])
                    ->setName($array['name'])
                    ->setSubmissionDate($array['submissionDate']);
            }
        }
        return $collection;
    }

    public function setName($name)
    {
        $this->name = (string)$name;
        return $this;
    }

    public function setEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
        } else {
            throw new \InvalidArgumentException('Not a valid email!');
        }
        return $this;
    }

    public function setComment($comment)
    {
        if (strlen($comment) < 10) {
            throw new \InvalidArgumentException('Comment too short!');
        } else {
            $this->comment = $comment;
        }
        return $this;
    }

    protected function setSubmissionDate($submissionDate)
    {
        $this->submissionDate = $submissionDate;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function getSubmissionDate()
    {
        return $this->submissionDate;
    }

    public function save()
    {
        if ($this->getName() && $this->getEmail() && $this->getComment()) {
            $this->setSubmissionDate(date('Y-m-d H:i:s'));
            dump($this);

            return $this->database->insert('comments', [
                'name' => $this->getName(),
                'email' => $this->getEmail(),
                'comment' => $this->getComment(),
                'submissionDate' => $this->getSubmissionDate()
            ]);
        }
        throw new \Exception("Failed to save!");
    }
}
