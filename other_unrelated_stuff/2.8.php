<?php


class Posts
{
    public  function __construct()
    {
        $this->postModel = $this->model('post');
    }

    public function index()
    {
        return true;
    }
    public function add()
    {
        return false;
    }
    public function edit($id)
    {
        $post = $this->postModel->fetchpost($id);
        $this->view('edit', ['post'=> $post]);
    }
}
?>
<h1><?php echo $data['title']; ?></h1>