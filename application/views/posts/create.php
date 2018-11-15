<h2><?php echo $title; ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open_multipart('posts/create'); ?>
  <div class="form-group">
    <label>Title</label>
    <input type="text" class="form-control" placeholder="Add Title" name="title">
  </div>
  <div class="form-group">
    <label>Body</label>
    <textarea type="text" id="editor1" class="form-control" name="body" placeholder="Add Body"></textarea>
  </div>
    <div class="form-group">
        <label>Catogory</label>
         <select name="category_id" class="form-control">
          <?php foreach($categories as $category):?>
            <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?>
            </option>
            <?php endforeach; ?>
         </select>
  </div>
  <div class="form-group">
  <label>
    <input type="file" name="userfile" size="20">
  </label></div>
     <button type="submit" class="btn btn-primary">Create Post</button>
</form>