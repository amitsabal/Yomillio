<!-- New thread popup -->
<div class="newThreadsFull" ng-controller="forumController">
    <div class="newThreadsContainer"></div>
    <div class="newThreadsPopup">
        <a href="#" class="newThreadsClosePopup newThreadsClosePopupIcon"><i class="fa fa-close"></i></a>
        <div class="center-margin">
            <p class="font-family-medium text-extra-extra-large">Add New Thread</p>
        </div>
        <hr>
        <form class="newThreadsForm" id="newThreadsForm" name="newThreadsForm" method="post" >
            <div class="col-xs-12 no-padding">
                <select class="width_100 padding-10" id="thread_category" ng-model="forum.category_id" placeholder="Select Category">
                    <option value="" disabled selected>Select Category</option>
                    {if isset($response.forumcategories)}
                    {foreach from=$response.forumcategories name=category item=category} 
                        <option value="{$category->id}">{$category->title}</option>
                    {/foreach}
                    {/if}
                </select>
            </div>
            <div class="col-xs-12 no-padding padding-top-20">
                <div class="threadHeading col-xs-12 no-padding">
                    <input type="text" class="threadHeadingInput form-control" name="threadHeading" id="thread_heading" placeholder="Thread Heading" maxlength="1024" ng-model="forum.title" required />
                </div>
                <div class="threadContent col-xs-12 no-padding padding-top-20">
                    <textarea rows="5" cols="50" class="width_100 padding-10 threadContentInput" placeholder="Thread Description" maxlength="5000" ng-model="forum.summary"></textarea>
                </div>
                
                <div class="col-xs-12 no-padding margin-top-20">
                    <div class="col-xs-12 col-md-12 no-padding">
                        <div class="col-xs-3 col-xs-offset-2">
                        <label for="forum_tags">Enter Secure Code <span class="text-red">*</span> : </label>
                        <img id="captcha" src="{$APP_BASE_URL}captcha" alt="CAPTCHA Image" style="border: 1px solid #000; margin-right: 15px" />
                        </div>
                        <div class="col-xs-4">                        
                        <input type="text" name="captcha_code" id="captcha_code" size="10" maxlength="6" ng-model="forum.captcha_code" />
                        <a href="#" onclick="document.getElementById('captcha').src = '/securimage/securimage_show.php?' + Math.random(); return false">
                            <img src="{$MEDIA_FILES_URL}images/refresh.png" height="32" width="32" alt="Reload Image" onclick="this.blur()" align="bottom" border="0">
                        </a>
                        </div>
                        <span class="col-xs-12 label label-danger">{if isset($response.error) && isset($response.error.captcha_code)}{$response.error.captcha_code}{/if}</span>
                    </div>
                </div>
                
                <div class="col-xs-12 no-padding margin-top-10 threadSubmitBtn">
                    <button type="button" class="btn btn-blue pull-right" id="thread_submit_btn" ng-click="searchForum(forum);" ng-disabled="disableSubmitButton"> SUBMIT </button>
                </div>
                
            </div>
        </form>
    </div>
    <!-- Similar Threads -->
    <div class="similarThreadsPopup">
        <a href="#" class="similarThreadsClosePopup similarThreadsClosePopupIcon"><i class="fa fa-close"></i></a>
        <div class="center-margin">
            <p class="font-family-medium text-extra-extra-large">Check for similar threads</p>
            <p class="text-gray" ng-bind="forum.title"></p>
        </div>
        <hr>
        <div class="col-xs-12 no-padding padding-top-20">
            <div class="similarThread col-xs-12 no-padding">
                <p ng-repeat="thread in similarThreads"><a href="{$APP_BASE_URL}forum/{literal}{{thread.perma_link}}{/literal}" target="_blank" ng-bind="thread.title"></a></p>
            </div>
            <div class="col-xs-12 no-padding margin-top-10 threadSubmitBtn">
                <button type="submit" class="btn btn-blue pull-right" id="thread_submit_btn2" ng-click="addForum(forum);"  ng-disabled="disableSubmitButton"> My Thread is New </button>
                <button type="submit" class="btn btn-logIn pull-right margin-horizontal-10" id="back_add_thread">Edit My Thread</button>
            </div>
        </div>
    </div>
</div>
<!-- New thread popup -->