<div class="addNewArticle inactive">
    <div class="newArticleContainer closePopup"></div>
    <div class="newArticleContent">
        <a href="#" class="closeNewArticlePopup closePopupIcon linkBlack"><i class="fa fa-close"></i></a>
        <h4>Add Article</h4>
        <form id="addArticleForm" action="{$APP_BASE_URL}article/create" method="post" enctype="multipart/form-data" onsubmit="return ValidateArticle();">
            <input type="hidden" name="content" id="article_content" value="" />
            <div class="col-xs-12 no-padding">
                <input type="text" placeholder="Title" class="width_100 space10" name="title" id="article_title" maxlength="500"></input>
            </div>
            <div class="clearfix"></div>
            <div id="editor" class="margin-top-20"></div>
            <div class="col-xs-12 no-padding margin-top-20">
                <select class="width_100" name="category"  id="article_category">
                    <option value="" selected>Select Category</option>
                    {foreach from=$response.categories name=key item=category}
                    <option value="{$category->id}">{$category->title}</option>
                    {/foreach}
                </select>
            </div>
            <div class="col-xs-12 no-padding">
                <ul id="myTags" class="margin-top-20" placeholder="tags">
                </ul>
            </div>
            <div class="col-xs-12 col-sm-12 no-padding">
                <div class="profileupload ">
                    <div class="uploadimg padding-5"><input type="file" name="article_image"  id="article_image" /><i class="fa fa-paperclip"></i><span> Attach Images</span></div>
                    <img src="" class="img-responsive space10 articleImg inactive" alt="profile" style="height: 50px;" />
                </div>
            </div>
            <div class="col-xs-12 no-padding margin-top-10 articleSubmitButton">
                <button type="submit" class="btn btn-blue pull-right" id="articleSubmitButton"> SUBMIT </button>
            </div>
        </form>
    </div>
</div>