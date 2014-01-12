<?php
namespace App\Controller;

class AdminController
    extends ActionController
{
    public function loginAction()
    {
        if ($_POST['admin']) {
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
        $paginator = $this->_di->get('Paginator', ['collection' => $resource]);
        $reviewCollection = $this->_di->get('ReviewCollection', ['resource' => $resource]);

        $paginator
            ->setItemCountPerPage(5)
            ->setCurrentPageNumber(isset($_GET['p']) ? $_GET['p'] : 1);
        $pages = $paginator->getPages();

        if ($filter = $_POST['filter']) {
            $reviewCollection->filterBy($filter['field'], $filter['value']);
        }

        return $this->_di->get('View', [
            'template' => 'admin_reviews',
            'params' => [
                'pages' => $pages,
                'header' => 'Admin Panel - Reviews',
                'view' => 'admin_reviews'
            ]
        ]);
    }

    public function editReviewAction()
    {
        $this->_isAdminLoggedIn();

        if ($_POST['review']) {

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
