<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use App\Models\category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateBlogRequest;

class BlogController extends Controller
{
    public function getBlogs(Request $request )
    {

        $user = Auth::user()->user_id;

        $userdata = User::where('user_id', $user)->first();

        $blogsObj = Blog::where('user_id', $user)->with('category');

        $blogforcategoryId = $blogsObj->get();

        if(!empty($request->category_id)){
            $blogsObj->where('category_id',$request->category_id);
        }

        $categoryIds = $blogforcategoryId->pluck('category_id')->unique();

        $userBlogsCategories = category::whereIn('category_id', $categoryIds)->get();

        $blogs = $blogsObj->get();

        return response()->json(['blogs' => $blogs, 'user' => $userdata,'blogsCategories' => $userBlogsCategories]);
    }

    public function createBlog(CreateBlogRequest $request)
    {

        $data = $request->all();

        $createBlog =  Blog::create([

            'user_id'       => $data['user_id'],
            'category_id'   => $data['category_id'],
            'title'         => $data['title'],
            'description'   => $data['description'],
            'image'         => $data['image'],
            'status'        => $data['status']

        ]);

        return response()->json(['createBlog' => $createBlog, 'message' => 'success']);

    }

    public function updateBlog(Request $request)
    {

        $data = $request->all();

        $updateBlog = Blog::where('blog_id', $request->id)->update([

            'user_id'       => $data['user_id'],
            'category_id'   => $data['category_id'],
            'title'         => $data['title'],
            'description'   => $data['description'],
            'image'         => $data['image'],
            'status'        => $data['status']

        ]);

        return response()->json(['updateBlog' => $updateBlog, 'message' => 'success']);
    }

    public function deleteBlog($id)
    {

        Blog::where('blog_id', $id)->delete();

        return response()->json(['message' => 'success delete']);

    }
}
