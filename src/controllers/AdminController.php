<?php
namespace App\Controller;

class AdminController
    extends ActionController
{
    public function loginAction()
    {
        if (isset($_POST['admin'])) {
            $admin = $this->_di->get('Admin', ['data' => $_POST['admin']]);
            $session = $this->_di->get('Session');
            $session->authAdmin($admin);
            $this->_redirect('product_list');
        } else {
            return $this->_di->get('View',
                [
                    'template' => 'admin_login',
                    'params' => [
                        'header' => 'Admin Login',
                        'view' => 'admin_login',
                        'css' => 'customer_auth'
                    ]
                ]);
        }
    }

    public function reviewsAction()
    {
        $this->_isAdminLoggedIn();

        $resource = $this->_di->get('ResourceCollection', ['table' =>  new \App\Model\Resource\Table\Review]);
        $reviewResource = $this->_di->get('ResourceEntity', ['table' =>  new \App\Model\Resource\Table\Review]);
        $paginator = $this->_di->get('Paginator', ['collection' => $resource]);
        $product = $this->_di->get('Product', ['table' => new \App\Model\Resource\Table\Product]);
        $reviewCollection = $this->_di->get('ReviewCollection',
            [
                'resource' => $resource,
                'productPrototype' => $product,
                'reviewResource' => $reviewResource
            ]);

        $paginator
            ->setItemCountPerPage(5)
            ->setCurrentPageNumber(isset($_GET['p']) ? $_GET['p'] : 1);
        $pages = $paginator->getPages();

        if (isset($_POST['filter'])) {
            $filter = $_POST['filter'];
            $reviewCollection->filterBy($filter['field'], $filter['value']);
        }

        return $this->_di->get('View', [
            'template' => 'admin_reviews',
            'params' => [
                'pages' => $pages,
                'reviewCollection' => $reviewCollection,
                'header' => 'Admin Panel - Reviews',
                'view' => 'admin_reviews'
            ]
        ]);
    }

    public function editReviewAction()
    {
        $this->_isAdminLoggedIn();

        if (isset($_POST['review'])) {
            if (isset($_POST['action']) && $_POST['action'] == 'Save') {
                $review = $this->_di->get('Review', ['data' => $_POST['review']]);
                $review->save();
                $this->_redirect('admin_reviews');
            } elseif (isset($_POST['action']) && $_POST['action'] == 'Remove') {
                $review = $this->_di->get('Review');
                $review->load($_POST['review']['review_id']);
                $review->remove();
                $this->_redirect('admin_reviews');
            }
        } else {
            $review = $this->_di->get('Review', ['table' => new \App\Model\Resource\Table\Review]);
            $review->load($_GET['review_id']);
            $productResource = $this->_di->get('ResourceCollection', ['table' => new \App\Model\Resource\Table\Product]);
            $productCollection = $this->_di->get('ProductCollection', ['resource' => $productResource]);

            return $this->_di->get('View', [
                'template' => 'admin_editReview',
                'params' => [
                    'review' => $review,
                    'productCollection' => $productCollection,
                    'header' => 'Admin Panel - Edit Review',
                    'view' => 'admin_editReview'
                ]
            ]);
        }

    }

    public function addReviewAction() {
        $this->_isAdminLoggedIn();

        if (isset($_POST['review'])) {
            $review = $this->_di->get('Review', ['data' => $_POST['review']]);
            $review->save();
            $this->_redirect('admin_reviews');
        } else {
            return $this->_di->get('View', [
                'template' => 'admin_addReview',
                'params' => [
                    'header' => 'Admin Panel - Add Review',
                    'view' => 'admin_addReview'
                ]
            ]);
        }
    }

    private function _isAdminLoggedIn()
    {
        $session = $this->_di->get('Session');
        if (!$session->isAdminLoggedIn()) {
            $this->_redirect('admin_login');
        }
    }
}
