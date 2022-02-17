<?php

function uploadFile($file)
{
    $file_name = 'image_'.time().'.'.$file->guessExtension();
    $tmp_file = $photo['tmp_name'];
  //  $img = Image::make($tmp_file);
    $img->save(public_path('/uploads/course_images/'.$file_name));
    return $file_name;
}