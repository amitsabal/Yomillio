{extends file='layouts/layout.tpl'}

{block name="css"}
    <link rel="stylesheet" href="{$MEDIA_FILES_URL}css/viewAll.css">
    <link rel="stylesheet" href="{$MEDIA_FILES_URL}css/jquery-ui.min.css">
    <link rel="stylesheet" href="{$MEDIA_FILES_URL}css/jquery.tagit.css">
    <link rel="stylesheet" href="{$MEDIA_FILES_URL}css/tagit.ui-zendesk.css">
{/block}

{block name="content"}
<div class="viewAllArticle bg-light-gray" ng-model="type_id">
    <div class="container">
        <div class="col-xs-7 no-padding">
            <div class="font-family-light text-26 margin-vertical-10"><div class="arrow_box"></div>{$response.pageTitle|upper}</div>
        </div>
        <div class="col-xs-5 no-padding">
            <ol class="breadcrumb">
              <li><a href="{$APP_BASE_URL}" class="text-dark-gray">Home</a></li>
              <li><a href="{$APP_BASE_URL}articles" class="text-dark-gray">Articles</a></li>
              <li class="active">Submit Yours</li>
            </ol>
        </div>
    </div>
</div>

<div class="container bg-white">
    <div class="selectCategoryArticle">
        <div class="col-xs-12 padding-vertical-50">
            <form id="addArticleForm" action="{$APP_BASE_URL}article/create" method="post" enctype="multipart/form-data" onsubmit="return ValidateArticle();">
                <input type="hidden" name="content" id="article_content" value="" />
                <div class="col-xs-12 no-padding">
                    <div class="col-xs-3 col-sm-2 col-md-1 no-padding">
                        <label for="article_title">Title <span class="text-red">*</span> : </label>
                    </div>
                    <div class="col-xs-9 col-sm-10 col-md-11 no-right-padding">
                        <input type="text" placeholder="Title" class="width_100 space10 form-control" name="title" id="article_title" maxlength="500"></input>
                        <span class="col-xs-12 label label-danger">{if isset($response.error) && isset($response.error.title)}{$response.error.title}{/if}</span>
                    </div>
                </div>
                <div class="col-xs-12 no-padding margin-top-20">
                    <div class="col-xs-3 col-sm-2 col-md-1 no-padding">
                        <label for="article_category">Category <span class="text-red">*</span> : </label>
                    </div>
                    <div class="col-xs-9 col-sm-10 col-md-11 no-right-padding">
                        <select class="width_100" name="category"  id="article_category" placeholder="Select Category">
                            <option value="" selected disabled>Select Category</option>
                            {foreach from=$response.categories name=key item=category}
                            <option value="{$category->id}">{$category->title}</option>
                            {/foreach}
                        </select>
                        <span class="col-xs-12 label label-danger">{if isset($response.error) && isset($response.error.category)}{$response.error.category}{/if}</span>
                    </div>
                </div>
                <div class="clearfix"></div>
                <br/>
                <div class="col-xs-12 no-padding">
                    <div class="col-xs-12 col-sm-2 col-md-1 no-padding">
                        <label for="article_content">Content <span class="text-red">*</span> : </label>
                    </div>
                    <div class="col-xs-12 col-sm-10 col-md-11 no-right-padding">
                        <div id="editor" class="margin-top-20"></div>
                    </div>
                    <span class="col-xs-12 label label-danger">{if isset($response.error) && isset($response.error.content)}{$response.error.content}{/if}</span>
                </div>
                <div class="clearfix"></div>
                <br/>
                <div class="col-xs-12 no-padding margin-top-20">
                    <div class="col-xs-3 col-sm-2 col-md-1 no-padding">
                        <label for="article_tags">Tags <span class="text-red">*</span> : </label>
                    </div>
                    <div class="col-xs-9 col-sm-10 col-md-11 no-right-padding">
                        <ul id="myTags" class="form-control" placeholder="tags">
                        </ul>
                        <span class="col-xs-12 label label-danger">{if isset($response.error) && isset($response.error.tags)}{$response.error.tags}{/if}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 no-padding">
                     <div class="col-xs-3 col-sm-2 col-md-1 no-padding">
                        <label for="article_image">Image <span class="text-red">*</span> : </label>
                    </div>
                    <div class="col-xs-9 col-sm-10 col-md-11 no-right-padding">
                        <div class="profileupload ">
                            <div class="uploadimg padding-5"><input type="file" name="article_image"  id="article_image" /><i class="fa fa-paperclip"></i><span> Attach Images</span></div>
                            <img src="" class="img-responsive space10 articleImg inactive" alt="profile" style="height: 50px;" />
                        </div>
                    </div>
                    <span class="col-xs-12 label label-danger">{if isset($response.error) && isset($response.error.article_image)}{$response.error.article_image}{/if}</span>
                </div>
                <div class="col-xs-12 no-padding margin-top-20">
                    <div class="col-xs-12 col-md-12 no-padding">
                        <div class="col-xs-3 col-xs-offset-2">
                            <label for="article_tags">Enter Secure Code <span class="text-red">*</span> : </label>
                            <img id="captcha" src="{$APP_BASE_URL}captcha" alt="CAPTCHA Image" style="border: 1px solid #000; margin-right: 15px" />
                        </div>
                        <div class="col-xs-4">                        
                            <input type="text" name="captcha_code" size="10" maxlength="6" />
                            <a href="#" onclick="document.getElementById('captcha').src = '/securimage/securimage_show.php?' + Math.random(); return false">
                                <img src="{$MEDIA_FILES_URL}images/refresh.png" height="32" width="32" alt="Reload Image" onclick="this.blur()" align="bottom" border="0">
                            </a>
                        </div>
                        <span class="col-xs-12 label label-danger">{if isset($response.error) && isset($response.error.captcha_code)}{$response.error.captcha_code}{/if}</span>
                    </div>
                </div>
                <div class="col-xs-12 no-padding margin-top-10 articleSubmitButton">
                    <button type="submit" class="btn btn-blue pull-right" id="articleSubmitButton" {if !isset($smarty.session) || !isset($smarty.session.session_user) || !isset($smarty.session.session_user->id)}disabled{/if}> SUBMIT </button>
                </div>
            </form>
        </div>
    </div>
</div>
{/block}


{block name="js"}    
    <script src="{$MEDIA_FILES_URL}js/bower_components/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <script src="{$MEDIA_FILES_URL}js/tag-it.min.js" type="text/javascript"></script>
    <script src="//cdn.ckeditor.com/4.5.1/standard/ckeditor.js"></script>
    <script src="{$MEDIA_FILES_URL}js/bower_components/adapters/jquery.js" type="text/javascript"></script>
    <script src="{$MEDIA_FILES_URL}js/ckEditorCode.js" type="text/javascript"></script>
    <script type="text/javascript">
        pageName = "{$response.pageTitle|upper}";
        $("#myTags").tagit();
		//Intialise the editor
		initSample();
    </script>
{/block}