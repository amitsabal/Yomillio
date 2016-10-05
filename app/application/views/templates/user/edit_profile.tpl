{extends file='layouts/layout.tpl'}

{block name="css"}
<link rel="stylesheet" href="{$MEDIA_FILES_URL}css/profile.css">

{/block}

<!-- {block name="js"}
<script src="{$MEDIA_FILES_URL}js/user.js"></script>
{/block} -->

{block name="content"}
<div class="searchResultDiv bg-light-black">
    <div class="container no-padding">
        <div class="col-xs-12 no-pading">
            <div class="font-family-light text-26 text-white margin-vertical-10 font-italic">MY PROFILE</div>
        </div>
    </div>
</div>
<div class="container bg-light-blue no-padding">
    <div class="lastLogin" ng-model="user" ng-model="lastLogin">
        <ul>
            <li>JOINED</li>
            <li class="active">{$response.profile->user->created_at|date_format}</li>
            <li>LAST LOGIN</li>
            <li class="active">{if isset($response.profile->user_last_login->created_at)}{$response.profile->user_last_login->created_at|date_format}{/if}</li>
            <div class="clearfix visible-xs"></div>
            <li class="active pull-right">{count($response.profile->user_comments)}</li>
            <li class="pull-right">COMMENTS</li>
            <li class="active pull-right">0</li>
            <li class="pull-right">POSTS</li>
        </ul>
    </div>
</div>
<div class="container bg-white" ng-model="user">
    <div class="col-xs-12 col-md-10 no-padding margin-top-30">
        <div class="col-xs-12">
            <h3>Basic Profile</h3>
            <hr/>
        </div>
        <div class="col-xs-12">
            <form name="profileEditForm" method="post">
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email" placeholder="Email" class="form-control" disabled="disabled" value="{$response.profile->user->email}" />
                </div>
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="first_name" placeholder="Enter First Name" class="form-control" value="{$response.profile->user->first_name}" />
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="last_name" placeholder="Enter Last Name" class="form-control" value="{$response.profile->user->last_name}" />
                </div>
                <div class="form-group">
                    <label>Job Title</label>
                    <input type="text" name="last_name" placeholder="Enter Last Name" class="form-control"  value="{$response.profile->user->linkedin_job_title}" />
                </div>
                <div class="form-group">
                    <label>Profile Picture</label>
                    <input type="file" name="profile_picture" placeholder="Select Your Profile Picture" />
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-default">Save</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-xs-12 col-md-10 no-padding margin-top-30">
        <div class="col-xs-12">
            <h3>Skills</h3>
            <hr/>
        </div>
        <div>
            
        </div>
    </div>
</div>
{/block}