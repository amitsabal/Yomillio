<!-- Comments Starts -->
<div class="clearfix"></div>
<div class="articleCommentDiv col-xs-12 no-padding">
    <div class="text-large text-bold text-gray margin-bottom-10" tabindex="-1">
        THERE <span id="commentClause">{if $article->comments|count == 1}IS{else}ARE{/if}</span> <b class="text-blue" ng-bind="commentsCount"> </b> COMMENT<span id="commentClause1">{if $article->comments|count == 1}{else}S{/if}</span>.
        <a href="#" class="padding-left-5 text-gray" ng-click="articleCommentShow()">SOMETHING TO SAY? </a>
    </div>
    {foreach from=$article->comments item=comment}
    <div class="articleComment margin-top-10">
        <div class="col-xs-3 col-sm-1 no-padding commenterName">
            <a href="{$comment->linkedin_profile_url}" target="_blank">
                {if isset($comment->linkedin_picture_url) && strlen(trim($comment->linkedin_picture_url)) > 0
                    && !isset($comment->profile_pic) && strlen(trim($comment->profile_pic)) <= 0}
                    <img src="{$comment->linkedin_picture_url}" alt="" class="width_90 center-margin border-2-orange radius-5" />
                {else if isset($comment->profile_pic) && strlen(trim($comment->profile_pic)) > 0}
                    <img src="{$MEDIA_FILES_URL}uploads/images/profile/{$comment->profile_pic}" alt="" class="width_90 center-margin border-2-orange radius-5" />
                {else}
                    <img src="{$MEDIA_FILES_URL}/images/user.png" alt="" class="width_90 center-margin border-2-orange radius-5"/>
                {/if}
                
            </a>
        </div>
        <div class="col-xs-9 articleRelatedComment margin-top-10">
            <p class="articleCommenterName">{$comment->comment}</p>
            <div class="text-medium text-gray margin-bottom-10">Posted By <span class="articleCommenterName text-medium text-orange">{$comment->first_name} {$comment->last_name}</span>     
            Date <span class="text-medium">{$comment->created_at|date_format:'d M Y'}, Time {$comment->created_at|date_format:'h:i A'}</span>
            </div>
        </div>
       
        <div class="clearfix"></div>
    </div>
    {/foreach}
    {literal}
    <div class="articleComment margin-top-20" ng-repeat="comment in comments" ng-if="comments.length > 0">
        <div class="col-xs-3 col-sm-1 no-padding">
            <a href="{{comment.linkedin_profile_url}}" target="_blank" ng-if="comment.linkedin_profile_url != ''">
                <span ng-if="comment.linkedin_picture_url == null && comment.profile_pic == null">
                    <img src="{/literal}{{$MEDIA_FILES_URL}}{literal}/images/user.png" alt="" class="width_90 center-margin border-2-orange radius-5"/>
                </span>
                
                <span ng-if="comment.linkedin_picture_url != null && comment.linkedin_picture_url != '' && comment.profile_pic == null  && comment.profile_pic == ''">
                    <img src="{{comment.linkedin_picture_url}}" alt="" class="width_90 center-margin border-2-orange radius-5" />
                </span>
                
                <span ng-if="comment.profile_pic != null  && comment.profile_pic != ''">
                    <img src="{{comment.profile_pic}}" alt="" class="width_90 center-margin border-2-orange radius-5"/>
                </span>
                
            </a>
        </div>
        <div class="col-xs-9 margin-top-10">
            <div class="col-xs-12 no-padding articleRelatedComment">
                <p class="articleCommenterName" ng-bind="comment.comment"></p>
            </div>
            <div class="text-medium text-gray margin-bottom-10">Posted By
                <span class="articleCommenterName text-medium text-orange" ng-bind="comment.first_name+' '+comment.last_name"></span>                        
                Date <span class="text-medium" ng-bind="comment.created_at | customDateFormat | date:'dd MMM yyyy'"></span>, Time <span class="text-medium" ng-bind="comment.created_at | customDateFormat | date:'hh:mm:ss a'"></span>
            </div>
        </div>
       
        <div class="clearfix"></div>
    </div>
    <div class="articleCommentHere col-xs-12 no-padding margin-top-20 margin-bottom-20" id="article_comment_show">
        <div class="toCommentLogin text-large text-bold text-gray margin-bottom-20" before-log-in-display>
            SOMETHING TO SAY? <div class="visible-xs"><br /></div> <a href="#" class="btn-blue loginbtn logInButton">LOG IN</a> OR <a href="#" class="btn-blue registerButton btn-padding loginbtn">SIGN UP</a>
        </div>
        
        <div class="toCommentHere" after-log-in-display ng-model="comment">
            <form name="commentForm" ng-submit="addComment(comment);">
                <textarea class="width_100" id="commentArea" rows="8" cols="50"  ng-model="comment.comment" placeholder="Enter Comment" class="form-control"></textarea>
                {/literal}
                <div class="col-xs-12 no-padding margin-top-20">
                    <div class="col-xs-12 col-md-12 no-padding">
                        <div class="col-xs-3 col-xs-offset-2">
                            <label for="article_tags">Enter Secure Code <span class="text-red">*</span> : </label>
                            <img id="captcha" src="{$APP_BASE_URL}captcha" alt="CAPTCHA Image" style="border: 1px solid #000; margin-right: 15px" />
                        </div>
                        <div class="col-xs-4">                        
                            <input type="text" name="captcha_code" id = "captcha_code" size="10" maxlength="6" ng-model="comment.captcha_code" />
                            <a href="#" onclick="document.getElementById('captcha').src = '{$APP_BASE_URL}captcha?' + Math.random(); return false" id="reloadCaptcha">
                                <img src="{$MEDIA_FILES_URL}images/refresh.png" height="32" width="32" alt="Reload Image" onclick="this.blur()" align="bottom" border="0">
                            </a>
                        </div>
                        <span class="col-xs-12 label label-danger">{if isset($response.error) && isset($response.error.captcha_code)}{$response.error.captcha_code}{/if}</span>
                    </div>
                </div>
                <div class="col-xs-12 no-padding margin-top-10">
                    <button class="btn btn-box-orange commentsubmit" type="submit">SUBMIT</button>
                </div>
                {literal}
                <!-- <button class="btn btn-box-orange commentsubmit" type="submit">SUBMIT</button>-->
            </form>
        </div>
    </div>

    {/literal}
</div>
<!-- Comments Ends -->