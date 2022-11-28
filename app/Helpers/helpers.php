<?php
/**
 * Created by PhpStorm.
 * User: sandesh
 * Date: 4/23/19
 * Time: 1:49 PM
 */
use App\Models\Category;

function uploadImage($image, $dir_name){
    $path = public_path()."/uploads/".$dir_name;

    if(!File::exists($path)){
        File::makeDirectory($path, 0777, true, true);
    }

    $file_name = ucfirst($dir_name)."-".date('YmdHis').rand(0,99).".".$image->getClientOriginalExtension();
    $success = $image->move($path, $file_name);
    if($success){
        return $file_name;
    } else {
        return false;
    }
}

function getCategoryLinks(){
    $category = new Category();
    $category_list = $category->getCategories();
    if($category_list) {
        ?>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                Category
            </a>

            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <?php
                    foreach($category_list as $category_info){
                        if($category_info->child_cats->count() > 0){
                        ?>
                            <li class="nav-item dropdown">
                                <a class="dropdown-item dropdown-toggle" href="#" id="navbarDropdown1" role="button"
                                   data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">
                                    <?php echo $category_info->title;?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown1">
                                    <?php
                                        foreach($category_info->child_cats as $children){
                                            ?>
                                            <li><a class="dropdown-item" href="<?php echo route('child-cat-list', $children->slug);?>"><?php echo $children->title;?></a></li>
                                            <?php
                                        }
                                    ?>
                                </ul>
                            </li>
                        <?php
                        } else {
                            ?>
                            <li><a class="dropdown-item" href="<?php echo route('category-list', $category_info->slug);?>"><?php echo $category_info->title;?></a></li>
                            <?php
                        }
                    }

                ?>



            </ul>
        </li>
        <?php
    }
}


function getYoutubeVideoId($url){
    //
}
