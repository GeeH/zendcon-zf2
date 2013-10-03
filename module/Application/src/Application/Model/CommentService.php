<?php
namespace Application\Model;

use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class CommentService
{

    /**
     * @var TableGateway
     */
    protected $commentTable;
    /**
     * @var string
     */
    protected $referer;

    /**
     * @param TableGateway $commentTable
     */
    function __construct(TableGateway $commentTable)
    {
        $this->commentTable = $commentTable;
    }

    /**
     * @return string
     */
    public function getReferer()
    {
        return $this->referer;
    }

    /**
     * @param string $referer
     */
    public function setReferer($referer)
    {
        $this->referer = $referer;
    }

    /**
     * @param Comment $comment
     * @return mixed
     */
    public function save(Comment $comment)
    {

        $data = array(
            'name' => $comment->getName(),
            'email' => $comment->getEmail(),
            'comment' => $comment->getComment(),
            'created' => new Expression('NOW()'),
            'referer' => $this->referer
        );
        if (is_null($comment->getId())) {
            return $this->commentTable->insert($data);
        }

        return $this->commentTable->update($data, array('id' => $comment->getComment()));
    }

    /**
     * @param null $referer
     * @param int $limit
     * @return Comment[]
     */
    public function fetchAll($referer = null, $limit = 10)
    {
        if (is_null($referer)) {
            $referer = $this->referer;
        }

        $select = new Select('comment');
        $select->where(array('referer' => $referer));
        $select->order('created DESC');
        $select->limit($limit);

        $return = $this->commentTable->selectWith($select);

        return $return;
    }
}

