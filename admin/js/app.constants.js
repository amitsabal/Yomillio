'use strict'

app.constant('REST_API_URL', host_base_url + "src/");
app.constant('APP_BASE_URL', host_base_url + "");
app.constant('APP_URL', host_base_url);
if (host_base_url == "http://www.zinnov.com/rti/admin/" || host_base_url == "http://zinnov.com/rti/admin/") {
    app.constant('APP_MEDIA_URL', "http://r2i.zinnov.com/app/media/");
}
else
    app.constant('APP_MEDIA_URL', host_base_url + "app/media/");
app.constant('LIST_PAGE_SIZE', 10);

app.constant('API',
    {
        "LOGIN"  : "adminusers/login",
        "LOGOUT" : "adminusers/logout",
        "SESSION_CHECK" : "adminusers/sessioncheck",
        
        "ADMIN_USERS_LIST" : "adminusers/getall",
        "ADMIN_USERS_CREATE" : "adminusers/create",
        "ADMIN_USERS_UPDATE" : "adminusers/update",
        "ADMIN_USERS_GET" : "adminusers/get",
        "ADMIN_USERS_CHANGE_PASSWORD" : "adminusers/changepassword",
        
        "ARTICLES_LIST"   : "articles/getall",
        "ARTICLES_GET"    : "articles/get",
        "ARTICLES_CREATE" : "articles/create",
        "ARTICLES_UPDATE" : "articles/update",
        "ARTICLES_DELETE" : "articles/delete",
        
        "CATEGORIES_LIST"   : "categories/getall",
        "CATEGORIES_GET"    : "categories/get",
        "CATEGORIES_CREATE" : "categories/create",
        "CATEGORIES_UPDATE" : "categories/update",
        "CATEGORIES_DDL"    : "categories/ddl",
        
        "TAGS_LIST"   : "tags/getall",
        "TAGS_GET"    : "tags/get",
        "TAGS_CREATE" : "tags/create",
        "TAGS_UPDATE" : "tags/update",
        "TAGS_DDL"    : "tags/ddl",
        
        "COMMENTS_LIST"   : "comments/getall",
        "COMMENTS_GET"    : "comments/get",
        "COMMENTS_UPDATE" : "comments/update",
        
        "USERS_LIST"   : "users/getall",
        "USERS_GET"    : "users/get",
        "USERS_UPDATE" : "users/update",
        
        "WEBPAGES_CREATE" : "webpages/create",
        "WEBPAGES_LIST"   : "webpages/getall",
        "WEBPAGES_GET"    : "webpages/get",
        "WEBPAGES_UPDATE" : "webpages/update",
        
        "FORUM_CATEGORIES_LIST"   : "forumcategories/getall",
        "FORUM_CATEGORIES_GET"    : "forumcategories/get",
        "FORUM_CATEGORIES_CREATE" : "forumcategories/create",
        "FORUM_CATEGORIES_UPDATE" : "forumcategories/update",
        "FORUM_CATEGORIES_DDL"    : "forumcategories/ddl",
        
        
        "FORUMS_LIST" : "forums/getall",
        "FORUMS_GET"  : "forums/get",
        "FORUMS_DELETE" : "forums/delete",
        "FORUMS_UPDATE" : "forums/update",        
        
    });

