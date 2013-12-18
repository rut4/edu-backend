<?php
namespace App\Controller;

class ReviewController
extends ActionController
{
    public function addAction()
    {
        if ($this->_validRequest())
        {
            $data = $_POST;

            $resource = $this->_di->get('ResourceEntity', ['table' => new \App\Model\Resource\Table\Review]);
            $review = $this->_di->get('Review', ['data' => $data, 'resource' => $resource]);
            $review->save();

        }
    }

    private function _validRequest()
    {
        return $this->_di->get('Session')
            ->validateToken($_POST['token']);
    }
} 