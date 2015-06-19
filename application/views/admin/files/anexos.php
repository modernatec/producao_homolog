<form id="upload" method="post" action="<?=URL::base();?>admin/users/upload?>" enctype="multipart/form-data">
    <div id="drop">
        Drop Here

        <a>Browse</a>
        <input type="file" name="upl" multiple />
    </div>
    <ul>
        <!-- The file uploads will be shown here -->
    </ul>
</form>