<?php
include 'partials/header.php'
?>


<section class="form__section">
    <div class="container form__section-container">
        <h2>Edit Post</h2>
        <form action="" enctype="multipart/form-data">
            <input type="text" placeholder="Title">
            <select>
                <option value="1">Survival Horror</option>
                <option value="1">Strategy</option>
                <option value="1">Open World</option>
                <option value="1">Fighting</option>
                <option value="1">Shooter</option>
            </select>
            <textarea rows="10" placeholder="Body"></textarea>
            <div class="form__control inline">
                <input type="checkbox" id="is_featured" checked>
                <label for="is_featured">Featured</label>
            </div>
            <div class="form__control">
                <label for="thumbnail">Change Thumbnail</label>
                <input type="file" id="thumbnail">
            </div>
            <button type="submit" class="btn">Update Post</button>
        </form>
    </div>
</section>


<?php
include '../partials/footer.php'
?>
