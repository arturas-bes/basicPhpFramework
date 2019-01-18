<?php

class Posts extends Controller
{
    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        $this->postModel = $this->model('Post');
        $this->userModel = $this->model('User');
    }

    public function index()
    {
        $posts = $this->postModel->getPosts();
        $data = [
            'posts' => $posts
        ];
        $this->view('/posts/index', $data);
    }
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize post array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'body_err' => ''
            ];

            //Validate data
            if (empty($data['title'])) {
                $data['title_err'] = 'Please enter title';
            }
            if (empty($data['body'])) {
                $data['body_err'] = 'Please enter text';
            }
            // Check for errors
            if (empty($data['title_err']) && empty($data['body_err'])) {
                if ($this->postModel->addPost($data)) {
                    flash('post_message', 'Post added successfully');
                    redirect('posts');


                } else {
                    die('Something went wrong');
                }
            } else {
                //Load the view with errors
                $this->view('posts/add', $data);
            }

        } else {
            $data = [
                'title' => '',
                'body' => ''
            ];
            $this->view('posts/add', $data);
        }
    }
    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize post array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'id' => $id,
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'body_err' => ''
            ];

            //Validate data
            if (empty($data['title'])) {
                $data['title_err'] = 'Please enter title';
            }
            if (empty($data['body'])) {
                $data['body_err'] = 'Please enter text';
            }

            // Check for errors
            if (empty($data['title_err']) && empty($data['body_err'])) {
                if ($this->postModel->updatePost($data)) {
                    flash('post_message', 'Post edited successfully');
                    redirect('posts');


                } else {
                    die('Something went wrong');
                }
            } else {
                //Load the view with errors
                $this->view('posts/edit', $data);
            }
        } else {
            // get existing post form model
            $post  = $this->postModel->getPost($id);
            //check for owner
            if ($post->user_id != $_SESSION['user_id']) {
                redirect('posts');
            }

            $data = [
                'id' => $id,
                'title' => $post->title,
                'body' => $post->body
            ];
            $this->view('posts/edit', $data);
        }
    }
    public function show($id)
    {
        $post = $this->postModel->getPost($id);
        $user = $this->userModel->findUserById($post->user_id);

        $data = [
            'post' => $post,
            'user' => $user
        ];
        $this->view('posts/show', $data);
    }
    public function delete($id)
    {
        // get existing post form model
        $post  = $this->postModel->getPost($id);
        //check for owner
        if ($post->user_id != $_SESSION['user_id']) {
            redirect('posts');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->postModel->deletePost($id)) {
                flash('post_message', 'Post has been removed');
                redirect('posts');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('posts');
        }
    }
}
