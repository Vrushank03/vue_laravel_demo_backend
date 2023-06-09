<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use App\Models\category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateBlogRequest;
use App\Http\Requests\UpdateBlogRequest;

class BlogController extends Controller
{
    public function getBlogs(Request $request )
    {

        $user = Auth::user();

        $blogsObj = Blog::where('user_id', $user->user_id)->with('category');

        $blogforcategoryId = $blogsObj->get();

        if(!empty($request->category_id)){
            $blogsObj->where('category_id',$request->category_id);
        }

        $categoryIds = $blogforcategoryId->pluck('category_id')->unique();

        $userBlogsCategories = category::whereIn('category_id', $categoryIds)->get();

        $blogs = $blogsObj->get();

        return response()->json(['blogs' => $blogs, 'user' => $user,'blogsCategories' => $userBlogsCategories]);
    }

    public function createBlog(CreateBlogRequest $request)
    {

        $data = $request->all();

        $createBlog =  Blog::create($data);

        return response()->json(['createBlog' => $createBlog, 'message' => 'success']);

    }

    public function updateBlog(UpdateBlogRequest $request)
    {

        $data = $request->all();

        $blog = Blog::where('blog_id',$request->blog_id)->first();

        $message = null;

        if(!empty($blog)){

            $blog->update($data);
            $blog = Blog::find($request->blog_id);
            $message = 'Success';
        }
        else{
            $message = 'Blog does not exit!!';
        }

        return response()->json(['updateBlog' => $blog, 'message' => $message ]);
    }

    public function deleteBlog($id)
    {

        $blog = Blog::where('blog_id',$id)->first();

        $message = null;

        if(!empty($blog)){

            $blog->delete();
            $message = 'Success';
        }
        else{

            $message = 'Blog does not exit!!';

        }

        return response()->json(['message' => $message]);

    }
}
