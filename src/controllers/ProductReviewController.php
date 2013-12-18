<?php
namespace App\Controller;

class ProductReviewController
    extends ActionController
{
    public function addAction()
    {
        if ($this->_validRequest()) {
            $data = $_POST;
            unset($data['review_id']);
            unset($data['token']);

            $review = $this->_di->get('ProductReview', ['data' => $data]);
            $review->save();

            $this->_redirect('product_view', ['id' => $data['product_id']]);
        } else {
            $this->_redirect('product_list');
        }
    }

    private function _validRequest()
    {
        return isset($_POST['token']) &&
            $this->_di->get('Session')->validateToken($_POST['token']);
    }
}
