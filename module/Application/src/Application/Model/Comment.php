<?php
namespace Application\Model;

class Comment
{
    protected $_id;
    protected $_name;
    protected $_email;
    protected $_comment;
    protected $_created;
    protected $_referer;

    /**
     * @return mixed
     */
    public function getReferer()
    {
        return $this->_referer;
    }

    /**
     * @param mixed $referer
     */
    public function setReferer($referer)
    {
        $this->_referer = $referer;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->_created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->_created = $created;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->_comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->_comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->_email = $email;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

}

