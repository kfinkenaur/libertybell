#
#<?php die('Forbidden.'); ?>
#Date: 2016-03-31 14:58:52 UTC
#Software: Joomla Platform 13.1.0 Stable [ Curiosity ] 24-Apr-2013 00:00 GMT

#Fields: datetime	priority clientip	category	message
2016-03-31T14:58:52+00:00	ERROR 76.179.16.230	com_cjblog	createMenuItems: exception 'UnexpectedValueException' with message 'JTableMenu::moveByReference(325, last-child, 325) parenting to child.' in /home/liberuy2/public_html/libraries/joomla/table/nested.php:338
Stack trace:
#0 /home/liberuy2/public_html/libraries/joomla/table/nested.php(830): JTableNested->moveByReference(325, 'last-child', '325')
#1 /home/liberuy2/public_html/libraries/legacy/table/menu.php(243): JTableNested->store(false)
#2 /home/liberuy2/public_html/administrator/components/com_cjblog/models/install.php(176): JTableMenu->store()
#3 /home/liberuy2/public_html/administrator/components/com_cjblog/models/install.php(55): CjBlogModelInstall->createMenuItems(Array, Array)
#4 /home/liberuy2/public_html/LibertyBell/tmp/install_56fd3b2be1d5a/packages/install_56fd3b2bed9d0/script.php(115): CjBlogModelInstall->createMenu()
#5 /home/liberuy2/public_html/libraries/cms/installer/adapter.php(978): com_cjblogInstallerScript->postflight('install', Object(JInstallerAdapterComponent))
#6 /home/liberuy2/public_html/libraries/cms/installer/adapter.php(769): JInstallerAdapter->triggerManifestScript('postflight')
#7 /home/liberuy2/public_html/libraries/cms/installer/installer.php(469): JInstallerAdapter->install()
#8 /home/liberuy2/public_html/libraries/cms/installer/adapter/package.php(128): JInstaller->install('/home/liberuy2/...')
#9 /home/liberuy2/public_html/libraries/cms/installer/adapter.php(692): JInstallerAdapterPackage->copyBaseFiles()
#10 /home/liberuy2/public_html/libraries/cms/installer/installer.php(469): JInstallerAdapter->install()
#11 /home/liberuy2/public_html/administrator/components/com_installer/models/install.php(158): JInstaller->install('/home/liberuy2/...')
#12 /home/liberuy2/public_html/administrator/components/com_installer/controllers/install.php(33): InstallerModelInstall->install()
#13 /home/liberuy2/public_html/libraries/legacy/controller/legacy.php(728): InstallerControllerInstall->install()
#14 /home/liberuy2/public_html/administrator/components/com_installer/installer.php(19): JControllerLegacy->execute('install')
#15 /home/liberuy2/public_html/libraries/cms/component/helper.php(405): require_once('/home/liberuy2/...')
#16 /home/liberuy2/public_html/libraries/cms/component/helper.php(380): JComponentHelper::executeComponent('/home/liberuy2/...')
#17 /home/liberuy2/public_html/libraries/cms/application/administrator.php(98): JComponentHelper::renderComponent('com_installer')
#18 /home/liberuy2/public_html/libraries/cms/application/administrator.php(152): JApplicationAdministrator->dispatch()
#19 /home/liberuy2/public_html/libraries/cms/application/cms.php(257): JApplicationAdministrator->doExecute()
#20 /home/liberuy2/public_html/administrator/index.php(51): JApplicationCms->execute()
#21 {main}| Table: JTableMenu Object
(
    [parent_id] => 325
    [level] => 1
    [lft] => 443
    [rgt] => 444
    [alias] => categories
    [_location:protected] => last-child
    [_location_id:protected] => 325
    [_cache:protected] => Array
        (
        )

    [_debug:protected] => 0
    [_tbl:protected] => #__menu
    [_tbl_key:protected] => id
    [_tbl_keys:protected] => Array
        (
            [0] => id
        )

    [_db:protected] => JDatabaseDriverMysqli Object
        (
            [name] => mysqli
            [serverType] => mysql
            [connection:protected] => mysqli Object
                (
                    [affected_rows] => 1
                    [client_info] => 5.5.36
                    [client_version] => 50536
                    [connect_errno] => 0
                    [connect_error] => 
                    [errno] => 0
                    [error] => 
                    [error_list] => Array
                        (
                        )

                    [field_count] => 1
                    [host_info] => Localhost via UNIX socket
                    [info] => 
                    [insert_id] => 0
                    [server_info] => 5.5.48-cll
                    [server_version] => 50548
                    [stat] => Uptime: 1034767  Threads: 3  Questions: 7593074  Slow queries: 0  Opens: 29461  Flush tables: 1  Open tables: 379  Queries per second avg: 7.337
                    [sqlstate] => 00000
                    [protocol_version] => 10
                    [thread_id] => 102686
                    [warning_count] => 0
                )

            [nameQuote:protected] => `
            [nullDate:protected] => 0000-00-00 00:00:00
            [_database:JDatabaseDriver:private] => liberuy2_vxbvn
            [count:protected] => 141
            [cursor:protected] => 
            [debug:protected] => 
            [limit:protected] => 0
            [log:protected] => Array
                (
                )

            [timings:protected] => Array
                (
                )

            [callStacks:protected] => Array
                (
                )

            [offset:protected] => 0
            [options:protected] => Array
                (
                    [driver] => mysqli
                    [host] => localhost
                    [user] => liberuy2_lsm
                    [password] => Lib3rtyB3ll
                    [database] => liberuy2_vxbvn
                    [prefix] => vxbvn_
                    [select] => 1
                    [port] => 3306
                    [socket] => 
                )

            [sql:protected] => JDatabaseQueryMysqli Object
                (
                    [offset:protected] => 0
                    [limit:protected] => 0
                    [db:protected] => JDatabaseDriverMysqli Object
 *RECURSION*
                    [sql:protected] => 
                    [type:protected] => select
                    [element:protected] => 
                    [select:protected] => JDatabaseQueryElement Object
                        (
                            [name:protected] => SELECT
                            [elements:protected] => Array
                                (
                                    [0] => id
                                )

                            [glue:protected] => ,
                        )

                    [delete:protected] => 
                    [update:protected] => 
                    [insert:protected] => 
                    [from:protected] => JDatabaseQueryElement Object
                        (
                            [name:protected] => FROM
                            [elements:protected] => Array
                                (
                                    [0] => #__menu
                                )

                            [glue:protected] => ,
                        )

                    [join:protected] => 
                    [set:protected] => 
                    [where:protected] => JDatabaseQueryElement Object
                        (
                            [name:protected] => WHERE
                            [elements:protected] => Array
                                (
                                    [0] => lft BETWEEN 443 AND 444
                                )

                            [glue:protected] =>  AND 
                        )

                    [group:protected] => 
                    [having:protected] => 
                    [columns:protected] => 
                    [values:protected] => 
                    [order:protected] => 
                    [autoIncrementField:protected] => 
                    [call:protected] => 
                    [exec:protected] => 
                    [union:protected] => 
                    [unionAll:protected] => 
                )

            [tablePrefix:protected] => vxbvn_
            [utf:protected] => 1
            [utf8mb4:protected] => 1
            [errorNum:protected] => 0
            [errorMsg:protected] => 
            [transactionDepth:protected] => 0
            [disconnectHandlers:protected] => Array
                (
                )

        )

    [_trackAssets:protected] => 
    [_rules:protected] => 
    [_locked:protected] => 
    [_autoincrement:protected] => 1
    [_observers:protected] => JObserverUpdater Object
        (
            [observers:protected] => Array
                (
                )

            [doCallObservers:protected] => 1
        )

    [_columnAlias:protected] => Array
        (
        )

    [_jsonEncode:protected] => Array
        (
        )

    [_errors:protected] => Array
        (
            [0] => UnexpectedValueException Object
                (
                    [message:protected] => JTableMenu::moveByReference(325, last-child, 325) parenting to child.
                    [string:Exception:private] => exception 'UnexpectedValueException' with message 'JTableMenu::moveByReference(325, last-child, 325) parenting to child.' in /home/liberuy2/public_html/libraries/joomla/table/nested.php:338
Stack trace:
#0 /home/liberuy2/public_html/libraries/joomla/table/nested.php(830): JTableNested->moveByReference(325, 'last-child', '325')
#1 /home/liberuy2/public_html/libraries/legacy/table/menu.php(243): JTableNested->store(false)
#2 /home/liberuy2/public_html/administrator/components/com_cjblog/models/install.php(176): JTableMenu->store()
#3 /home/liberuy2/public_html/administrator/components/com_cjblog/models/install.php(55): CjBlogModelInstall->createMenuItems(Array, Array)
#4 /home/liberuy2/public_html/LibertyBell/tmp/install_56fd3b2be1d5a/packages/install_56fd3b2bed9d0/script.php(115): CjBlogModelInstall->createMenu()
#5 /home/liberuy2/public_html/libraries/cms/installer/adapter.php(978): com_cjblogInstallerScript->postflight('install', Object(JInstallerAdapterComponent))
#6 /home/liberuy2/public_html/libraries/cms/installer/adapter.php(769): JInstallerAdapter->triggerManifestScript('postflight')
#7 /home/liberuy2/public_html/libraries/cms/installer/installer.php(469): JInstallerAdapter->install()
#8 /home/liberuy2/public_html/libraries/cms/installer/adapter/package.php(128): JInstaller->install('/home/liberuy2/...')
#9 /home/liberuy2/public_html/libraries/cms/installer/adapter.php(692): JInstallerAdapterPackage->copyBaseFiles()
#10 /home/liberuy2/public_html/libraries/cms/installer/installer.php(469): JInstallerAdapter->install()
#11 /home/liberuy2/public_html/administrator/components/com_installer/models/install.php(158): JInstaller->install('/home/liberuy2/...')
#12 /home/liberuy2/public_html/administrator/components/com_installer/controllers/install.php(33): InstallerModelInstall->install()
#13 /home/liberuy2/public_html/libraries/legacy/controller/legacy.php(728): InstallerControllerInstall->install()
#14 /home/liberuy2/public_html/administrator/components/com_installer/installer.php(19): JControllerLegacy->execute('install')
#15 /home/liberuy2/public_html/libraries/cms/component/helper.php(405): require_once('/home/liberuy2/...')
#16 /home/liberuy2/public_html/libraries/cms/component/helper.php(380): JComponentHelper::executeComponent('/home/liberuy2/...')
#17 /home/liberuy2/public_html/libraries/cms/application/administrator.php(98): JComponentHelper::renderComponent('com_installer')
#18 /home/liberuy2/public_html/libraries/cms/application/administrator.php(152): JApplicationAdministrator->dispatch()
#19 /home/liberuy2/public_html/libraries/cms/application/cms.php(257): JApplicationAdministrator->doExecute()
#20 /home/liberuy2/public_html/administrator/index.php(51): JApplicationCms->execute()
#21 {main}
                    [code:protected] => 0
                    [file:protected] => /home/liberuy2/public_html/libraries/joomla/table/nested.php
                    [line:protected] => 338
                    [trace:Exception:private] => Array
                        (
                            [0] => Array
                                (
                                    [file] => /home/liberuy2/public_html/libraries/joomla/table/nested.php
                                    [line] => 830
                                    [function] => moveByReference
                                    [class] => JTableNested
                                    [type] => ->
                                    [args] => Array
                                        (
                                            [0] => 325
                                            [1] => last-child
                                            [2] => 325
                                        )

                                )

                            [1] => Array
                                (
                                    [file] => /home/liberuy2/public_html/libraries/legacy/table/menu.php
                                    [line] => 243
                                    [function] => store
                                    [class] => JTableNested
                                    [type] => ->
                                    [args] => Array
                                        (
                                            [0] => 
                                        )

                                )

                            [2] => Array
                                (
                                    [file] => /home/liberuy2/public_html/administrator/components/com_cjblog/models/install.php
                                    [line] => 176
                                    [function] => store
                                    [class] => JTableMenu
                                    [type] => ->
                                    [args] => Array
                                        (
                                        )

                                )

                            [3] => Array
                                (
                                    [file] => /home/liberuy2/public_html/administrator/components/com_cjblog/models/install.php
                                    [line] => 55
                                    [function] => createMenuItems
                                    [class] => CjBlogModelInstall
                                    [type] => ->
                                    [args] => Array
                                        (
                                            [0] => Array
                                                (
                                                    [name] => CjBlog
                                                    [alias] => blog
                                                    [link] => index.php?option=com_cjblog&view=categories
                                                    [access] => 0
                                                    [params] => Array
                                                        (
                                                        )

                                                )

                                            [1] => Array
                                                (
                                                    [categories] => Array
                                                        (
                                                            [name] => Categories
                                                            [alias] => categories
                                                            [link] => index.php?option=com_cjblog&view=categories
                                                            [access] => 0
                                                            [params] => Array
                                                                (
                                                                )

                                                        )

                                                    [articles] => Array
                                                        (
                                                            [name] => Articles
                                                            [alias] => articles
                                                            [link] => index.php?option=com_cjblog&view=articles
                                                            [access] => 0
                                                            [params] => Array
                                                                (
                                                                )

                                                        )

                                                    [bloggers] => Array
                                                        (
                                                            [name] => Bloggers
                                                            [alias] => bloggers
                                                            [link] => index.php?option=com_cjblog&view=users
                                                            [access] => 0
                                                            [params] => Array
                                                                (
                                                                )

                                                        )

                                                    [badges] => Array
                                                        (
                                                            [name] => Badges
                                                            [alias] => badges
                                                            [link] => index.php?option=com_cjblog&view=badges
                                                            [access] => 0
                                                            [params] => Array
                                                                (
                                                                )

                                                        )

                                                    [points] => Array
                                                        (
                                                            [name] => Points
                                                            [alias] => points
                                                            [link] => index.php?option=com_cjblog&view=user
                                                            [access] => 1
                                                            [params] => Array
                                                                (
                                                                )

                                                        )

                                                    [profile] => Array
                                                        (
                                                            [name] => Profile
                                                            [alias] => profile
                                                            [link] => index.php?option=com_cjblog&view=profile
                                                            [access] => 0
                                                            [params] => Array
                                                                (
                                                                )

                                                        )

                                                    [blog] => Array
                                                        (
                                                            [name] => Blog
                                                            [alias] => blog
                                                            [link] => index.php?option=com_cjblog&view=blog
                                                            [access] => 0
                                                            [params] => Array
                                                                (
                                                                )

                                                        )

                                                    [form] => Array
                                                        (
                                                            [name] => Form
                                                            [alias] => form
                                                            [link] => index.php?option=com_cjblog&view=form
                                                            [access] => 1
                                                            [params] => Array
                                                                (
                                                                )

                                                        )

                                                )

                                        )

                                )

                            [4] => Array
                                (
                                    [file] => /home/liberuy2/public_html/LibertyBell/tmp/install_56fd3b2be1d5a/packages/install_56fd3b2bed9d0/script.php
                                    [line] => 115
                                    [function] => createMenu
                                    [class] => CjBlogModelInstall
                                    [type] => ->
                                    [args] => Array
                                        (
                                        )

                                )

                            [5] => Array
                                (
                                    [file] => /home/liberuy2/public_html/libraries/cms/installer/adapter.php
                                    [line] => 978
                                    [function] => postflight
                                    [class] => com_cjblogInstallerScript
                                    [type] => ->
                                    [args] => Array
                                        (
                                            [0] => install
                                            [1] => JInstallerAdapterComponent Object
                                                (
                                                    [oldAdminFiles:protected] => 
                                                    [oldFiles:protected] => 
                                                    [manifest_script:protected] => script.php
                                                    [install_script:protected] => 
                                                    [currentExtensionId:protected] => 
                                                    [element:protected] => com_cjblog
                                                    [extension:protected] => JTableExtension Object
                                                        (
                                                            [_tbl:protected] => #__extensions
                                                            [_tbl_key:protected] => extension_id
                                                            [_tbl_keys:protected] => Array
                                                                (
                                                                    [0] => extension_id
                                                                )

                                                            [_db:protected] => JDatabaseDriverMysqli Object
                                                                (
                                                                    [name] => mysqli
                                                                    [serverType] => mysql
                                                                    [connection:protected] => mysqli Object
                                                                        (
                                                                            [affected_rows] => -1
                                                                            [client_info] => 5.5.36
                                                                            [client_version] => 50536
                                                                            [connect_errno] => 0
                                                                            [connect_error] => 
                                                                            [errno] => 0
                                                                            [error] => 
                                                                            [error_list] => Array
                                                                                (
                                                                                )

                                                                            [field_count] => 1
                                                                            [host_info] => Localhost via UNIX socket
                                                                            [info] => 
                                                                            [insert_id] => 0
                                                                            [server_info] => 5.5.48-cll
                                                                            [server_version] => 50548
                                                                            [stat] => Uptime: 1034767  Threads: 3  Questions: 7593075  Slow queries: 0  Opens: 29461  Flush tables: 1  Open tables: 379  Queries per second avg: 7.337
                                                                            [sqlstate] => 00000
                                                                            [protocol_version] => 10
                                                                            [thread_id] => 102686
                                                                            [warning_count] => 0
                                                                        )

                                                                    [nameQuote:protected] => `
                                                                    [nullDate:protected] => 0000-00-00 00:00:00
                                                                    [_database:JDatabaseDriver:private] => liberuy2_vxbvn
                                                                    [count:protected] => 141
                                                                    [cursor:protected] => 
                                                                    [debug:protected] => 
                                                                    [limit:protected] => 0
                                                                    [log:protected] => Array
                                                                        (
                                                                        )

                                                                    [timings:protected] => Array
                                                                        (
                                                                        )

                                                                    [callStacks:protected] => Array
                                                                        (
                                                                        )

                                                                    [offset:protected] => 0
                                                                    [options:protected] => Array
                                                                        (
                                                                            [driver] => mysqli
                                                                            [host] => localhost
                                                                            [user] => liberuy2_lsm
                                                                            [password] => Lib3rtyB3ll
                                                                            [database] => liberuy2_vxbvn
                                                                            [prefix] => vxbvn_
                                                                            [select] => 1
                                                                            [port] => 3306
                                                                            [socket] => 
                                                                        )

                                                                    [sql:protected] => JDatabaseQueryMysqli Object
                                                                        (
                                                                            [offset:protected] => 0
                                                                            [limit:protected] => 0
                                                                            [db:protected] => JDatabaseDriverMysqli Object
 *RECURSION*
                                                                            [sql:protected] => 
                                                                            [type:protected] => select
                                                                            [element:protected] => 
                                                                            [select:protected] => JDatabaseQueryElement Object
                                                                                (
                                                                                    [name:protected] => SELECT
                                                                                    [elements:protected] => Array
                                                                                        (
                                                                                            [0] => id
                                                                                        )

                                                                                    [glue:protected] => ,
                                                                                )

                                                                            [delete:protected] => 
                                                                            [update:protected] => 
                                                                            [insert:protected] => 
                                                                            [from:protected] => JDatabaseQueryElement Object
                                                                                (
                                                                                    [name:protected] => FROM
                                                                                    [elements:protected] => Array
                                                                                        (
                                                                                            [0] => #__menu
                                                                                        )

                                                                                    [glue:protected] => ,
                                                                                )

                                                                            [join:protected] => 
                                                                            [set:protected] => 
                                                                            [where:protected] => JDatabaseQueryElement Object
                                                                                (
                                                                                    [name:protected] => WHERE
                                                                                    [elements:protected] => Array
                                                                                        (
                                                                                            [0] => lft BETWEEN 443 AND 444
                                                                                        )

                                                                                    [glue:protected] =>  AND 
                                                                                )

                                                                            [group:protected] => 
                                                                            [having:protected] => 
                                                                            [columns:protected] => 
                                                                            [values:protected] => 
                                                                            [order:protected] => 
                                                                            [autoIncrementField:protected] => 
                                                                            [call:protected] => 
                                                                            [exec:protected] => 
                                                                            [union:protected] => 
                                                                            [unionAll:protected] => 
                                                                        )

                                                                    [tablePrefix:protected] => vxbvn_
                                                                    [utf:protected] => 1
                                                                    [utf8mb4:protected] => 1
                                                                    [errorNum:protected] => 0
                                                                    [errorMsg:protected] => 
                                                                    [transactionDepth:protected] => 0
                                                                    [disconnectHandlers:protected] => Array
                                                                        (
                                                                        )

                                                                )

                                                            [_trackAssets:protected] => 
                                                            [_rules:protected] => 
                                                            [_locked:protected] => 
                                                            [_autoincrement:protected] => 1
                                                            [_observers:protected] => JObserverUpdater Object
                                                                (
                                                                    [observers:protected] => Array
                                                                        (
                                                                        )

                                                                    [doCallObservers:protected] => 1
                                                                )

                                                            [_columnAlias:protected] => Array
                                                                (
                                                                )

                                                            [_jsonEncode:protected] => Array
                                                                (
                                                                )

                                                            [_errors:protected] => Array
                                                                (
                                                                )

                                                            [extension_id] => 10058
                                                            [name] => CjBlog
                                                            [type] => component
                                                            [element] => com_cjblog
                                                            [folder] => 
                                                            [client_id] => 1
                                                            [enabled] => 1
                                                            [access] => 0
                                                            [protected] => 0
                                                            [manifest_cache] => {"name":"CjBlog","type":"component","creationDate":"2015-May-30","author":"Maverick","copyright":"Copyright corejoomla.com. All rights reserved.","authorEmail":"support@corejoomla.com","authorUrl":"http:\/\/www.corejoomla.org","version":"1.4.2","description":"CjBlog - Simple yet powerful blogging platform for Joomla!","group":"","filename":"install"}
                                                            [params] => {}
                                                            [custom_data] => 
                                                            [system_data] => 
                                                            [checked_out] => 
                                                            [checked_out_time] => 
                                                            [ordering] => 
                                                            [state] => 
                                                        )

                                                    [extensionMessage:protected] => <p>COM_CJBLOG_PREFLIGHT_install_TEXT</p>
                                                    [manifest] => SimpleXMLElement Object
                                                        (
                                                            [@attributes] => Array
                                                                (
                                                                    [method] => upgrade
                                                                    [type] => component
                                                                    [version] => 2.5.0
                                                                )

                                                            [name] => CjBlog
                                                            [creationDate] => 2015-May-30
                                                            [author] => Maverick
                                                            [authorEmail] => support@corejoomla.com
                                                            [authorUrl] => http://www.corejoomla.org
                                                            [copyright] => Copyright corejoomla.com. All rights reserved.
                                                            [license] => http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
                                                            [version] => 1.4.2
                                                            [description] => CjBlog - Simple yet powerful blogging platform for Joomla!
                                                            [install] => SimpleXMLElement Object
                                                                (
                                                                    [sql] => SimpleXMLElement Object
                                                                        (
                                                                            [file] => sql/install.mysql.utf8.sql
                                                                        )

                                                                )

                                                            [files] => SimpleXMLElement Object
                                                                (
                                                                    [@attributes] => Array
                                                                        (
                                                                            [folder] => site
                                                                        )

                                                                    [filename] => Array
                                                                        (
                                                                            [0] => index.html
                                                                            [1] => cjblog.php
                                                                            [2] => controller.php
                                                                            [3] => router.php
                                                                            [4] => api.php
                                                                        )

                                                                    [folder] => Array
                                                                        (
                                                                            [0] => controllers
                                                                            [1] => models
                                                                            [2] => views
                                                                            [3] => helpers
                                                                            [4] => layouts
                                                                        )

                                                                )

                                                            [media] => SimpleXMLElement Object
                                                                (
                                                                    [@attributes] => Array
                                                                        (
                                                                            [destination] => com_cjblog
                                                                            [folder] => site/media
                                                                        )

                                                                    [filename] => index.html
                                                                    [folder] => Array
                                                                        (
                                                                            [0] => css
                                                                            [1] => images
                                                                            [2] => js
                                                                        )

                                                                )

                                                            [languages] => SimpleXMLElement Object
                                                                (
                                                                    [@attributes] => Array
                                                                        (
                                                                            [folder] => site
                                                                        )

                                                                    [language] => language/en-GB/en-GB.com_cjblog.ini
                                                                )

                                                            [administration] => SimpleXMLElement Object
                                                                (
                                                                    [menu] => COM_CJBLOG
                                                                    [submenu] => SimpleXMLElement Object
                                                                        (
                                                                            [menu] => Array
                                                                                (
                                                                                    [0] => COM_CJBLOG_CONTROL_PANEL
                                                                                    [1] => COM_CJBLOG_BADGES
                                                                                    [2] => COM_CJBLOG_BADGE_RULES
                                                                                    [3] => COM_CJBLOG_BADGE_ACTIVITY
                                                                                    [4] => COM_CJBLOG_POINTS
                                                                                    [5] => COM_CJBLOG_POINT_RULES
                                                                                    [6] => COM_CJBLOG_USERS
                                                                                )

                                                                        )

                                                                    [files] => SimpleXMLElement Object
                                                                        (
                                                                            [@attributes] => Array
                                                                                (
                                                                                    [folder] => admin
                                                                                )

                                                                            [filename] => Array
                                                                                (
                                                                                    [0] => index.html
                                                                                    [1] => access.xml
                                                                                    [2] => config.xml
                                                                                    [3] => cjblog.php
                                                                                )

                                                                            [folder] => Array
                                                                                (
                                                                                    [0] => assets
                                                                                    [1] => controllers
                                                                                    [2] => helpers
                                                                                    [3] => models
                                                                                    [4] => sql
                                                                                    [5] => views
                                                                                )

                                                                        )

                                                                    [languages] => SimpleXMLElement Object
                                                                        (
                                                                            [@attributes] => Array
                                                                                (
                                                                                    [folder] => admin
                                                                                )

                                                                            [language] => Array
                                                                                (
                                                                                    [0] => language/en-GB/en-GB.com_cjblog.ini
                                                                                    [1] => language/en-GB/en-GB.com_cjblog.sys.ini
                                                                                )

                                                                        )

                                                                )

                                                            [scriptfile] => script.php
                                                            [updateservers] => SimpleXMLElement Object
                                                                (
                                                                    [server] => http://www.corejoomla.com/media/autoupdates/com_cjblog.xml
                                                                )

                                                        )

                                                    [name:protected] => CjBlog
                                                    [route:protected] => install
                                                    [supportsDiscoverInstall:protected] => 1
                                                    [type:protected] => component
                                                    [parent:protected] => JInstaller Object
                                                        (
                                                            [paths:protected] => Array
                                                                (
                                                                    [source] => /home/liberuy2/public_html/LibertyBell/tmp/install_56fd3b2be1d5a/packages/install_56fd3b2bed9d0
                                                                    [manifest] => /home/liberuy2/public_html/LibertyBell/tmp/install_56fd3b2be1d5a/packages/install_56fd3b2bed9d0/install.xml
                                                                    [extension_site] => /home/liberuy2/public_html/components/com_cjblog
                                                                    [extension_administrator] => /home/liberuy2/public_html/administrator/components/com_cjblog
                                                                    [extension_root] => /home/liberuy2/public_html/administrator/components/com_cjblog
                                                                )

                                                            [upgrade:protected] => 1
                                                            [manifestClass] => com_cjblogInstallerScript Object
                                                                (
                                                                )

                                                            [overwrite:protected] => 1
                                                            [stepStack:protected] => Array
                                                                (
                                                                    [0] => Array
                                                                        (
                                                                            [type] => folder
                                                                            [path] => /home/liberuy2/public_html/components/com_cjblog
                                                                        )

                                                                    [1] => Array
                                                                        (
                                                                            [type] => folder
                                                                            [path] => /home/liberuy2/public_html/administrator/components/com_cjblog
                                                                        )

                                                                    [2] => Array
                                                                        (
                                                                            [type] => file
                                                                            [path] => /home/liberuy2/public_html/components/com_cjblog/index.html
                                                                        )

                                                                    [3] => Array
                                                                        (
                                                                            [type] => file
                                                                            [path] => /home/liberuy2/public_html/components/com_cjblog/cjblog.php
                                                                        )

                                                                    [4] => Array
                                                                        (
                                                                            [type] => file
                                                                            [path] => /home/liberuy2/public_html/components/com_cjblog/controller.php
                                                                        )

                                                                    [5] => Array
                                                                        (
                                                                            [type] => file
                                                                            [path] => /home/liberuy2/public_html/components/com_cjblog/router.php
                                                                        )

                                                                    [6] => Array
                                                                        (
                                                                            [type] => file
                                                                            [path] => /home/liberuy2/public_html/components/com_cjblog/api.php
                                                                        )

                                                                    [7] => Array
                                                                        (
                                                                            [type] => folder
                                                                            [path] => /home/liberuy2/public_html/components/com_cjblog/controllers
                                                                        )

                                                                    [8] => Array
                                                                        (
                                                                            [type] => folder
                                                                            [path] => /home/liberuy2/public_html/components/com_cjblog/models
                                                                        )

                                                                    [9] => Array
                                                                        (
                                                                            [type] => folder
                                                                            [path] => /home/liberuy2/public_html/components/com_cjblog/views
                                                                        )

                                                                    [10] => Array
                                                                        (
                                                                            [type] => folder
                                                                            [path] => /home/liberuy2/public_html/components/com_cjblog/helpers
                                                                        )

                                                                    [11] => Array
                                                                        (
                                                                            [type] => folder
                                                                            [path] => /home/liberuy2/public_html/components/com_cjblog/layouts
                                                                        )

                                                                    [12] => Array
                                                                        (
                                                                            [type] => file
                                                                            [path] => /home/liberuy2/public_html/administrator/components/com_cjblog/index.html
                                                                        )

                                                                    [13] => Array
                                                                        (
                                                                            [type] => file
                                                                            [path] => /home/liberuy2/public_html/administrator/components/com_cjblog/access.xml
                                                                        )

                                                                    [14] => Array
                                                                        (
                                                                            [type] => file
                                                                            [path] => /home/liberuy2/public_html/administrator/components/com_cjblog/config.xml
                                                                        )

                                                                    [15] => Array
                                                                        (
                                                                            [type] => file
                                                                            [path] => /home/liberuy2/public_html/administrator/components/com_cjblog/cjblog.php
                                                                        )

                                                                    [16] => Array
                                                                        (
                                                                            [type] => folder
                                                                            [path] => /home/liberuy2/public_html/administrator/components/com_cjblog/assets
                                                                        )

                                                                    [17] => Array
                                                                        (
                                                                            [type] => folder
                                                                            [path] => /home/liberuy2/public_html/administrator/components/com_cjblog/controllers
                                                                        )

                                                                    [18] => Array
                                                                        (
                                                                            [type] => folder
                                                                            [path] => /home/liberuy2/public_html/administrator/components/com_cjblog/helpers
                                                                        )

                                                                    [19] => Array
                                                                        (
                                                                            [type] => folder
                                                                            [path] => /home/liberuy2/public_html/administrator/components/com_cjblog/models
                                                                        )

                                                                    [20] => Array
                                                                        (
                                                                            [type] => folder
                                                                            [path] => /home/liberuy2/public_html/administrator/components/com_cjblog/sql
                                                                        )

                                                                    [21] => Array
                                                                        (
                                                                            [type] => folder
                                                                            [path] => /home/liberuy2/public_html/administrator/components/com_cjblog/views
                                                                        )

                                                                    [22] => Array
                                                                        (
                                                                            [type] => file
                                                                            [path] => /home/liberuy2/public_html/administrator/components/com_cjblog/script.php
                                                                        )

                                                                    [23] => Array
                                                                        (
                                                                            [type] => file
                                                                            [path] => /home/liberuy2/public_html/media/com_cjblog/index.html
                                                                        )

                                                                    [24] => Array
                                                                        (
                                                                            [type] => folder
                                                                            [path] => /home/liberuy2/public_html/media/com_cjblog/css
                                                                        )

                                                                    [25] => Array
                                                                        (
                                                                            [type] => folder
                                                                            [path] => /home/liberuy2/public_html/media/com_cjblog/images
                                                                        )

                                                                    [26] => Array
                                                                        (
                                                                            [type] => folder
                                                                            [path] => /home/liberuy2/public_html/media/com_cjblog/js
                                                                        )

                                                                    [27] => Array
                                                                        (
                                                                            [type] => file
                                                                            [path] => /home/liberuy2/public_html/language/en-GB/en-GB.com_cjblog.ini
                                                                        )

                                                                    [28] => Array
                                                                        (
                                                                            [type] => file
                                                                            [path] => /home/liberuy2/public_html/administrator/language/en-GB/en-GB.com_cjblog.ini
                                                                        )

                                                                    [29] => Array
                                                                        (
                                                                            [type] => file
                                                                            [path] => /home/liberuy2/public_html/administrator/language/en-GB/en-GB.com_cjblog.sys.ini
                                                                        )

                                                                    [30] => Array
                                                                        (
                                                                            [type] => file
                                                                            [path] => /home/liberuy2/public_html/administrator/components/com_cjblog/install.xml
                                                                        )

                                                                    [31] => Array
                                                                        (
                                                                            [type] => menu
                                                                            [id] => 10058
                                                                        )

                                                                    [32] => Array
                                                                        (
                                                                            [type] => menu
                                                                            [id] => 10058
                                                                        )

                                                                    [33] => Array
                                                                        (
                                                                            [type] => menu
                                                                            [id] => 10058
                                                                        )

                                                                    [34] => Array
                                                                        (
                                                                            [type] => menu
                                                                            [id] => 10058
                                                                        )

                                                                    [35] => Array
                                                                        (
                                                                            [type] => menu
                                                                            [id] => 10058
                                                                        )

                                                                    [36] => Array
                                                                        (
                                                                            [type] => menu
                                                                            [id] => 10058
                                                                        )

                                                                    [37] => Array
                                                                        (
                                                                            [type] => menu
                                                                            [id] => 10058
                                                                        )

                                                                )

                                                            [extension] => JTableExtension Object
                                                                (
                                                                    [_tbl:protected] => #__extensions
                                                                    [_tbl_key:protected] => extension_id
                                                                    [_tbl_keys:protected] => Array
                                                                        (
                                                                            [0] => extension_id
                                                                        )

                                                                    [_db:protected] => JDatabaseDriverMysqli Object
                                                                        (
                                                                            [name] => mysqli
                                                                            [serverType] => mysql
                                                                            [connection:protected] => mysqli Object
                                                                                (
                                                                                    [affected_rows] => -1
                                                                                    [client_info] => 5.5.36
                                                                                    [client_version] => 50536
                                                                                    [connect_errno] => 0
                                                                                    [connect_error] => 
                                                                                    [errno] => 0
                                                                                    [error] => 
                                                                                    [error_list] => Array
                                                                                        (
                                                                                        )

                                                                                    [field_count] => 1
                                                                                    [host_info] => Localhost via UNIX socket
                                                                                    [info] => 
                                                                                    [insert_id] => 0
                                                                                    [server_info] => 5.5.48-cll
                                                                                    [server_version] => 50548
                                                                                    [stat] => Uptime: 1034767  Threads: 3  Questions: 7593076  Slow queries: 0  Opens: 29461  Flush tables: 1  Open tables: 379  Queries per second avg: 7.337
                                                                                    [sqlstate] => 00000
                                                                                    [protocol_version] => 10
                                                                                    [thread_id] => 102686
                                                                                    [warning_count] => 0
                                                                                )

                                                                            [nameQuote:protected] => `
                                                                            [nullDate:protected] => 0000-00-00 00:00:00
                                                                            [_database:JDatabaseDriver:private] => liberuy2_vxbvn
                                                                            [count:protected] => 141
                                                                            [cursor:protected] => 
                                                                            [debug:protected] => 
                                                                            [limit:protected] => 0
                                                                            [log:protected] => Array
                                                                                (
                                                                                )

                                                                            [timings:protected] => Array
                                                                                (
                                                                                )

                                                                            [callStacks:protected] => Array
                                                                                (
                                                                                )

                                                                            [offset:protected] => 0
                                                                            [options:protected] => Array
                                                                                (
                                                                                    [driver] => mysqli
                                                                                    [host] => localhost
                                                                                    [user] => liberuy2_lsm
                                                                                    [password] => Lib3rtyB3ll
                                                                                    [database] => liberuy2_vxbvn
                                                                                    [prefix] => vxbvn_
                                                                                    [select] => 1
                                                                                    [port] => 3306
                                                                                    [socket] => 
                                                                                )

                                                                            [sql:protected] => JDatabaseQueryMysqli Object
                                                                                (
                                                                                    [offset:protected] => 0
                                                                                    [limit:protected] => 0
                                                                                    [db:protected] => JDatabaseDriverMysqli Object
 *RECURSION*
                                                                                    [sql:protected] => 
                                                                                    [type:protected] => select
                                                                                    [element:protected] => 
                                                                                    [select:protected] => JDatabaseQueryElement Object
                                                                                        (
                                                                                            [name:protected] => SELECT
                                                                                            [elements:protected] => Array
                                                                                                (
                                                                                                    [0] => id
                                                                                                )

                                                                                            [glue:protected] => ,
                                                                                        )

                                                                                    [delete:protected] => 
                                                                                    [update:protected] => 
                                                                                    [insert:protected] => 
                                                                                    [from:protected] => JDatabaseQueryElement Object
                                                                                        (
                                                                                            [name:protected] => FROM
                                                                                            [elements:protected] => Array
                                                                                                (
                                                                                                    [0] => #__menu
                                                                                                )

                                                                                            [glue:protected] => ,
                                                                                        )

                                                                                    [join:protected] => 
                                                                                    [set:protected] => 
                                                                                    [where:protected] => JDatabaseQueryElement Object
                                                                                        (
                                                                                            [name:protected] => WHERE
                                                                                            [elements:protected] => Array
                                                                                                (
                                                                                                    [0] => lft BETWEEN 443 AND 444
                                                                                                )

                                                                                            [glue:protected] =>  AND 
                                                                                        )

                                                                                    [group:protected] => 
                                                                                    [having:protected] => 
                                                                                    [columns:protected] => 
                                                                                    [values:protected] => 
                                                                                    [order:protected] => 
                                                                                    [autoIncrementField:protected] => 
                                                                                    [call:protected] => 
                                                                                    [exec:protected] => 
                                                                                    [union:protected] => 
                                                                                    [unionAll:protected] => 
                                                                                )

                                                                            [tablePrefix:protected] => vxbvn_
                                                                            [utf:protected] => 1
                                                                            [utf8mb4:protected] => 1
                                                                            [errorNum:protected] => 0
                                                                            [errorMsg:protected] => 
                                                                            [transactionDepth:protected] => 0
                                                                            [disconnectHandlers:protected] => Array
                                                                                (
                                                                                )

                                                                        )

                                                                    [_trackAssets:protected] => 
                                                                    [_rules:protected] => 
                                                                    [_locked:protected] => 
                                                                    [_autoincrement:protected] => 1
                                                                    [_observers:protected] => JObserverUpdater Object
                                                                        (
                                                                            [observers:protected] => Array
                                                                                (
                                                                                )

                                                                            [doCallObservers:protected] => 1
                                                                        )

                                                                    [_columnAlias:protected] => Array
                                                                        (
                                                                        )

                                                                    [_jsonEncode:protected] => Array
                                                                        (
                                                                        )

                                                                    [_errors:protected] => Array
                                                                        (
                                                                        )

                                                                    [extension_id] => 
                                                                    [name] => 
                                                                    [type] => 
                                                                    [element] => 
                                                                    [folder] => 
                                                                    [client_id] => 
                                                                    [enabled] => 
                                                                    [access] => 1
                                                                    [protected] => 
                                                                    [manifest_cache] => 
                                                                    [params] => 
                                                                    [custom_data] => 
                                                                    [system_data] => 
                                                                    [checked_out] => 
                                                                    [checked_out_time] => 
                                                                    [ordering] => 
                                                                    [state] => 
                                                                )

                                                            [message] => CjBlog - Simple yet powerful blogging platform for Joomla!
                                                            [manifest] => SimpleXMLElement Object
                                                                (
                                                                    [@attributes] => Array
                                                                        (
                                                                            [method] => upgrade
                                                                            [type] => component
                                                                            [version] => 2.5.0
                                                                        )

                                                                    [name] => CjBlog
                                                                    [creationDate] => 2015-May-30
                                                                    [author] => Maverick
                                                                    [authorEmail] => support@corejoomla.com
                                                                    [authorUrl] => http://www.corejoomla.org
                                                                    [copyright] => Copyright corejoomla.com. All rights reserved.
                                                                    [license] => http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
                                                                    [version] => 1.4.2
                                                                    [description] => CjBlog - Simple yet powerful blogging platform for Joomla!
                                                                    [install] => SimpleXMLElement Object
                                                                        (
                                                                            [sql] => SimpleXMLElement Object
                                                                                (
                                                                                    [file] => sql/install.mysql.utf8.sql
                                                                                )

                                                                        )

                                                                    [files] => SimpleXMLElement Object
                                                                        (
                                                                            [@attributes] => Array
                                                                                (
                                                                                    [folder] => site
                                                                                )

                                                                            [filename] => Array
                                                                                (
                                                                                    [0] => index.html
                                                                                    [1] => cjblog.php
                                                                                    [2] => controller.php
                                                                                    [3] => router.php
                                                                                    [4] => api.php
                                                                                )

                                                                            [folder] => Array
                                                                                (
                                                                                    [0] => controllers
                                                                                    [1] => models
                                                                                    [2] => views
                                                                                    [3] => helpers
                                                                                    [4] => layouts
                                                                                )

                                                                        )

                                                                    [media] => SimpleXMLElement Object
                                                                        (
                                                                            [@attributes] => Array
                                                                                (
                                                                                    [destination] => com_cjblog
                                                                                    [folder] => site/media
                                                                                )

                                                                            [filename] => index.html
                                                                            [folder] => Array
                                                                                (
                                                                                    [0] => css
                                                                                    [1] => images
                                                                                    [2] => js
                                                                                )

                                                                        )

                                                                    [languages] => SimpleXMLElement Object
                                                                        (
                                                                            [@attributes] => Array
                                                                                (
                                                                                    [folder] => site
                                                                                )

                                                                            [language] => language/en-GB/en-GB.com_cjblog.ini
                                                                        )

                                                                    [administration] => SimpleXMLElement Object
                                                                        (
                                                                            [menu] => COM_CJBLOG
                                                                            [submenu] => SimpleXMLElement Object
                                                                                (
                                                                                    [menu] => Array
                                                                                        (
                                                                                            [0] => COM_CJBLOG_CONTROL_PANEL
                                                                                            [1] => COM_CJBLOG_BADGES
                                                                                            [2] => COM_CJBLOG_BADGE_RULES
                                                                                            [3] => COM_CJBLOG_BADGE_ACTIVITY
                                                                                            [4] => COM_CJBLOG_POINTS
                                                                                            [5] => COM_CJBLOG_POINT_RULES
                                                                                            [6] => COM_CJBLOG_USERS
                                                                                        )

                                                                                )

                                                                            [files] => SimpleXMLElement Object
                                                                                (
                                                                                    [@attributes] => Array
                                                                                        (
                                                                                            [folder] => admin
                                                                                        )

                                                                                    [filename] => Array
                                                                                        (
                                                                                            [0] => index.html
                                                                                            [1] => access.xml
                                                                                            [2] => config.xml
                                                                                            [3] => cjblog.php
                                                                                        )

                                                                                    [folder] => Array
                                                                                        (
                                                                                            [0] => assets
                                                                                            [1] => controllers
                                                                                            [2] => helpers
                                                                                            [3] => models
                                                                                            [4] => sql
                                                                                            [5] => views
                                                                                        )

                                                                                )

                                                                            [languages] => SimpleXMLElement Object
                                                                                (
                                                                                    [@attributes] => Array
                                                                                        (
                                                                                            [folder] => admin
                                                                                        )

                                                                                    [language] => Array
                                                                                        (
                                                                                            [0] => language/en-GB/en-GB.com_cjblog.ini
                                                                                            [1] => language/en-GB/en-GB.com_cjblog.sys.ini
                                                                                        )

                                                                                )

                                                                        )

                                                                    [scriptfile] => script.php
                                                                    [updateservers] => SimpleXMLElement Object
                                                                        (
                                                                            [server] => http://www.corejoomla.com/media/autoupdates/com_cjblog.xml
                                                                        )

                                                                )

                                                            [extension_message:protected] => 
                                                            [redirect_url:protected] => index.php?option=com_cjblog
                                                            [_adapters:protected] => Array
                                                                (
                                                                    [library] => JInstallerAdapterLibrary Object
                                                                        (
                                                                            [currentExtensionId:protected] => 
                                                                            [element:protected] => 
                                                                            [extension:protected] => JTableExtension Object
                                                                                (
                                                                                    [_tbl:protected] => #__extensions
                                                                                    [_tbl_key:protected] => extension_id
                                                                                    [_tbl_keys:protected] => Array
                                                                                        (
                                                                                            [0] => extension_id
                                                                                        )

                                                                                    [_db:protected] => JDatabaseDriverMysqli Object
                                                                                        (
                                                                                            [name] => mysqli
                                                                                            [serverType] => mysql
                                                                                            [connection:protected] => mysqli Object
                                                                                                (
                                                                                                    [affected_rows] => -1
                                                                                                    [client_info] => 5.5.36
                                                                                                    [client_version] => 50536
                                                                                                    [connect_errno] => 0
                                                                                                    [connect_error] => 
                                                                                                    [errno] => 0
                                                                                                    [error] => 
                                                                                                    [error_list] => Array
                                                                                                        (
                                                                                                        )

                                                                                                    [field_count] => 1
                                                                                                    [host_info] => Localhost via UNIX socket
                                                                                                    [info] => 
                                                                                                    [insert_id] => 0
                                                                                                    [server_info] => 5.5.48-cll
                                                                                                    [server_version] => 50548
                                                                                                    [stat] => Uptime: 1034767  Threads: 3  Questions: 7593077  Slow queries: 0  Opens: 29461  Flush tables: 1  Open tables: 379  Queries per second avg: 7.337
                                                                                                    [sqlstate] => 00000
                                                                                                    [protocol_version] => 10
                                                                                                    [thread_id] => 102686
                                                                                                    [warning_count] => 0
                                                                                                )

                                                                                            [nameQuote:protected] => `
                                                                                            [nullDate:protected] => 0000-00-00 00:00:00
                                                                                            [_database:JDatabaseDriver:private] => liberuy2_vxbvn
                                                                                            [count:protected] => 141
                                                                                            [cursor:protected] => 
                                                                                            [debug:protected] => 
                                                                                            [limit:protected] => 0
                                                                                            [log:protected] => Array
                                                                                                (
                                                                                                )

                                                                                            [timings:protected] => Array
                                                                                                (
                                                                                                )

                                                                                            [callStacks:protected] => Array
                                                                                                (
                                                                                                )

                                                                                            [offset:protected] => 0
                                                                                            [options:protected] => Array
                                                                                                (
                                                                                                    [driver] => mysqli
                                                                                                    [host] => localhost
                                                                                                    [user] => liberuy2_lsm
                                                                                                    [password] => Lib3rtyB3ll
                                                                                                    [database] => liberuy2_vxbvn
                                                                                                    [prefix] => vxbvn_
                                                                                                    [select] => 1
                                                                                                    [port] => 3306
                                                                                                    [socket] => 
                                                                                                )

                                                                                            [sql:protected] => JDatabaseQueryMysqli Object
                                                                                                (
                                                                                                    [offset:protected] => 0
                                                                                                    [limit:protected] => 0
                                                                                                    [db:protected] => JDatabaseDriverMysqli Object
 *RECURSION*
                                                                                                    [sql:protected] => 
                                                                                                    [type:protected] => select
                                                                                                    [element:protected] => 
                                                                                                    [select:protected] => JDatabaseQueryElement Object
                                                                                                        (
                                                                                                            [name:protected] => SELECT
                                                                                                            [elements:protected] => Array
                                                                                                                (
                                                                                                                    [0] => id
                                                                                                                )

                                                                                                            [glue:protected] => ,
                                                                                                        )

                                                                                                    [delete:protected] => 
                                                                                                    [update:protected] => 
                                                                                                    [insert:protected] => 
                                                                                                    [from:protected] => JDatabaseQueryElement Object
                                                                                                        (
                                                                                                            [name:protected] => FROM
                                                                                                            [elements:protected] => Array
                                                                                                                (
                                                                                                                    [0] => #__menu
                                                                                                                )

                                                                                                            [glue:protected] => ,
                                                                                                        )

                                                                                                    [join:protected] => 
                                                                                                    [set:protected] => 
                                                                                                    [where:protected] => JDatabaseQueryElement Object
                                                                                                        (
                                                                                                            [name:protected] => WHERE
                                                                                                            [elements:protected] => Array
                                                                                                                (
                                                                                                                    [0] => lft BETWEEN 443 AND 444
                                                                                                                )

                                                                                                            [glue:protected] =>  AND 
                                                                                                        )

                                                                                                    [group:protected] => 
                                                                                                    [having:protected] => 
                                                                                                    [columns:protected] => 
                                                                                                    [values:protected] => 
                                                                                                    [order:protected] => 
                                                                                                    [autoIncrementField:protected] => 
                                                                                                    [call:protected] => 
                                                                                                    [exec:protected] => 
                                                                                                    [union:protected] => 
                                                                                                    [unionAll:protected] => 
                                                                                                )

                                                                                            [tablePrefix:protected] => vxbvn_
                                                                                            [utf:protected] => 1
                                                                                            [utf8mb4:protected] => 1
                                                                                            [errorNum:protected] => 0
                                                                                            [errorMsg:protected] => 
                                                                                            [transactionDepth:protected] => 0
                                                                                            [disconnectHandlers:protected] => Array
                                                                                                (
                                                                                                )

                                                                                        )

                                                                                    [_trackAssets:protected] => 
                                                                                    [_rules:protected] => 
                                                                                    [_locked:protected] => 
                                                                                    [_autoincrement:protected] => 1
                                                                                    [_observers:protected] => JObserverUpdater Object
                                                                                        (
                                                                                            [observers:protected] => Array
                                                                                                (
                                                                                                )

                                                                                            [doCallObservers:protected] => 1
                                                                                        )

                                                                                    [_columnAlias:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [_jsonEncode:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [_errors:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [extension_id] => 
                                                                                    [name] => 
                                                                                    [type] => 
                                                                                    [element] => 
                                                                                    [folder] => 
                                                                                    [client_id] => 
                                                                                    [enabled] => 
                                                                                    [access] => 1
                                                                                    [protected] => 
                                                                                    [manifest_cache] => 
                                                                                    [params] => 
                                                                                    [custom_data] => 
                                                                                    [system_data] => 
                                                                                    [checked_out] => 
                                                                                    [checked_out_time] => 
                                                                                    [ordering] => 
                                                                                    [state] => 
                                                                                )

                                                                            [extensionMessage:protected] => 
                                                                            [manifest] => SimpleXMLElement Object
                                                                                (
                                                                                    [@attributes] => Array
                                                                                        (
                                                                                            [method] => upgrade
                                                                                            [type] => component
                                                                                            [version] => 2.5.0
                                                                                        )

                                                                                    [name] => CjBlog
                                                                                    [creationDate] => 2015-May-30
                                                                                    [author] => Maverick
                                                                                    [authorEmail] => support@corejoomla.com
                                                                                    [authorUrl] => http://www.corejoomla.org
                                                                                    [copyright] => Copyright corejoomla.com. All rights reserved.
                                                                                    [license] => http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
                                                                                    [version] => 1.4.2
                                                                                    [description] => CjBlog - Simple yet powerful blogging platform for Joomla!
                                                                                    [install] => SimpleXMLElement Object
                                                                                        (
                                                                                            [sql] => SimpleXMLElement Object
                                                                                                (
                                                                                                    [file] => sql/install.mysql.utf8.sql
                                                                                                )

                                                                                        )

                                                                                    [files] => SimpleXMLElement Object
                                                                                        (
                                                                                            [@attributes] => Array
                                                                                                (
                                                                                                    [folder] => site
                                                                                                )

                                                                                            [filename] => Array
                                                                                                (
                                                                                                    [0] => index.html
                                                                                                    [1] => cjblog.php
                                                                                                    [2] => controller.php
                                                                                                    [3] => router.php
                                                                                                    [4] => api.php
                                                                                                )

                                                                                            [folder] => Array
                                                                                                (
                                                                                                    [0] => controllers
                                                                                                    [1] => models
                                                                                                    [2] => views
                                                                                                    [3] => helpers
                                                                                                    [4] => layouts
                                                                                                )

                                                                                        )

                                                                                    [media] => SimpleXMLElement Object
                                                                                        (
                                                                                            [@attributes] => Array
                                                                                                (
                                                                                                    [destination] => com_cjblog
                                                                                                    [folder] => site/media
                                                                                                )

                                                                                            [filename] => index.html
                                                                                            [folder] => Array
                                                                                                (
                                                                                                    [0] => css
                                                                                                    [1] => images
                                                                                                    [2] => js
                                                                                                )

                                                                                        )

                                                                                    [languages] => SimpleXMLElement Object
                                                                                        (
                                                                                            [@attributes] => Array
                                                                                                (
                                                                                                    [folder] => site
                                                                                                )

                                                                                            [language] => language/en-GB/en-GB.com_cjblog.ini
                                                                                        )

                                                                                    [administration] => SimpleXMLElement Object
                                                                                        (
                                                                                            [menu] => COM_CJBLOG
                                                                                            [submenu] => SimpleXMLElement Object
                                                                                                (
                                                                                                    [menu] => Array
                                                                                                        (
                                                                                                            [0] => COM_CJBLOG_CONTROL_PANEL
                                                                                                            [1] => COM_CJBLOG_BADGES
                                                                                                            [2] => COM_CJBLOG_BADGE_RULES
                                                                                                            [3] => COM_CJBLOG_BADGE_ACTIVITY
                                                                                                            [4] => COM_CJBLOG_POINTS
                                                                                                            [5] => COM_CJBLOG_POINT_RULES
                                                                                                            [6] => COM_CJBLOG_USERS
                                                                                                        )

                                                                                                )

                                                                                            [files] => SimpleXMLElement Object
                                                                                                (
                                                                                                    [@attributes] => Array
                                                                                                        (
                                                                                                            [folder] => admin
                                                                                                        )

                                                                                                    [filename] => Array
                                                                                                        (
                                                                                                            [0] => index.html
                                                                                                            [1] => access.xml
                                                                                                            [2] => config.xml
                                                                                                            [3] => cjblog.php
                                                                                                        )

                                                                                                    [folder] => Array
                                                                                                        (
                                                                                                            [0] => assets
                                                                                                            [1] => controllers
                                                                                                            [2] => helpers
                                                                                                            [3] => models
                                                                                                            [4] => sql
                                                                                                            [5] => views
                                                                                                        )

                                                                                                )

                                                                                            [languages] => SimpleXMLElement Object
                                                                                                (
                                                                                                    [@attributes] => Array
                                                                                                        (
                                                                                                            [folder] => admin
                                                                                                        )

                                                                                                    [language] => Array
                                                                                                        (
                                                                                                            [0] => language/en-GB/en-GB.com_cjblog.ini
                                                                                                            [1] => language/en-GB/en-GB.com_cjblog.sys.ini
                                                                                                        )

                                                                                                )

                                                                                        )

                                                                                    [scriptfile] => script.php
                                                                                    [updateservers] => SimpleXMLElement Object
                                                                                        (
                                                                                            [server] => http://www.corejoomla.com/media/autoupdates/com_cjblog.xml
                                                                                        )

                                                                                )

                                                                            [manifest_script:protected] => 
                                                                            [name:protected] => 
                                                                            [route:protected] => install
                                                                            [supportsDiscoverInstall:protected] => 1
                                                                            [type:protected] => library
                                                                            [parent:protected] => JInstaller Object
 *RECURSION*
                                                                            [db:protected] => JDatabaseDriverMysqli Object
                                                                                (
                                                                                    [name] => mysqli
                                                                                    [serverType] => mysql
                                                                                    [connection:protected] => mysqli Object
                                                                                        (
                                                                                            [affected_rows] => -1
                                                                                            [client_info] => 5.5.36
                                                                                            [client_version] => 50536
                                                                                            [connect_errno] => 0
                                                                                            [connect_error] => 
                                                                                            [errno] => 0
                                                                                            [error] => 
                                                                                            [error_list] => Array
                                                                                                (
                                                                                                )

                                                                                            [field_count] => 1
                                                                                            [host_info] => Localhost via UNIX socket
                                                                                            [info] => 
                                                                                            [insert_id] => 0
                                                                                            [server_info] => 5.5.48-cll
                                                                                            [server_version] => 50548
                                                                                            [stat] => Uptime: 1034767  Threads: 3  Questions: 7593078  Slow queries: 0  Opens: 29461  Flush tables: 1  Open tables: 379  Queries per second avg: 7.337
                                                                                            [sqlstate] => 00000
                                                                                            [protocol_version] => 10
                                                                                            [thread_id] => 102686
                                                                                            [warning_count] => 0
                                                                                        )

                                                                                    [nameQuote:protected] => `
                                                                                    [nullDate:protected] => 0000-00-00 00:00:00
                                                                                    [_database:JDatabaseDriver:private] => liberuy2_vxbvn
                                                                                    [count:protected] => 141
                                                                                    [cursor:protected] => 
                                                                                    [debug:protected] => 
                                                                                    [limit:protected] => 0
                                                                                    [log:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [timings:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [callStacks:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [offset:protected] => 0
                                                                                    [options:protected] => Array
                                                                                        (
                                                                                            [driver] => mysqli
                                                                                            [host] => localhost
                                                                                            [user] => liberuy2_lsm
                                                                                            [password] => Lib3rtyB3ll
                                                                                            [database] => liberuy2_vxbvn
                                                                                            [prefix] => vxbvn_
                                                                                            [select] => 1
                                                                                            [port] => 3306
                                                                                            [socket] => 
                                                                                        )

                                                                                    [sql:protected] => JDatabaseQueryMysqli Object
                                                                                        (
                                                                                            [offset:protected] => 0
                                                                                            [limit:protected] => 0
                                                                                            [db:protected] => JDatabaseDriverMysqli Object
 *RECURSION*
                                                                                            [sql:protected] => 
                                                                                            [type:protected] => select
                                                                                            [element:protected] => 
                                                                                            [select:protected] => JDatabaseQueryElement Object
                                                                                                (
                                                                                                    [name:protected] => SELECT
                                                                                                    [elements:protected] => Array
                                                                                                        (
                                                                                                            [0] => id
                                                                                                        )

                                                                                                    [glue:protected] => ,
                                                                                                )

                                                                                            [delete:protected] => 
                                                                                            [update:protected] => 
                                                                                            [insert:protected] => 
                                                                                            [from:protected] => JDatabaseQueryElement Object
                                                                                                (
                                                                                                    [name:protected] => FROM
                                                                                                    [elements:protected] => Array
                                                                                                        (
                                                                                                            [0] => #__menu
                                                                                                        )

                                                                                                    [glue:protected] => ,
                                                                                                )

                                                                                            [join:protected] => 
                                                                                            [set:protected] => 
                                                                                            [where:protected] => JDatabaseQueryElement Object
                                                                                                (
                                                                                                    [name:protected] => WHERE
                                                                                                    [elements:protected] => Array
                                                                                                        (
                                                                                                            [0] => lft BETWEEN 443 AND 444
                                                                                                        )

                                                                                                    [glue:protected] =>  AND 
                                                                                                )

                                                                                            [group:protected] => 
                                                                                            [having:protected] => 
                                                                                            [columns:protected] => 
                                                                                            [values:protected] => 
                                                                                            [order:protected] => 
                                                                                            [autoIncrementField:protected] => 
                                                                                            [call:protected] => 
                                                                                            [exec:protected] => 
                                                                                            [union:protected] => 
                                                                                            [unionAll:protected] => 
                                                                                        )

                                                                                    [tablePrefix:protected] => vxbvn_
                                                                                    [utf:protected] => 1
                                                                                    [utf8mb4:protected] => 1
                                                                                    [errorNum:protected] => 0
                                                                                    [errorMsg:protected] => 
                                                                                    [transactionDepth:protected] => 0
                                                                                    [disconnectHandlers:protected] => Array
                                                                                        (
                                                                                        )

                                                                                )

                                                                            [_errors:protected] => Array
                                                                                (
                                                                                )

                                                                        )

                                                                    [template] => JInstallerAdapterTemplate Object
                                                                        (
                                                                            [clientId:protected] => 
                                                                            [currentExtensionId:protected] => 
                                                                            [element:protected] => 
                                                                            [extension:protected] => JTableExtension Object
                                                                                (
                                                                                    [_tbl:protected] => #__extensions
                                                                                    [_tbl_key:protected] => extension_id
                                                                                    [_tbl_keys:protected] => Array
                                                                                        (
                                                                                            [0] => extension_id
                                                                                        )

                                                                                    [_db:protected] => JDatabaseDriverMysqli Object
                                                                                        (
                                                                                            [name] => mysqli
                                                                                            [serverType] => mysql
                                                                                            [connection:protected] => mysqli Object
                                                                                                (
                                                                                                    [affected_rows] => -1
                                                                                                    [client_info] => 5.5.36
                                                                                                    [client_version] => 50536
                                                                                                    [connect_errno] => 0
                                                                                                    [connect_error] => 
                                                                                                    [errno] => 0
                                                                                                    [error] => 
                                                                                                    [error_list] => Array
                                                                                                        (
                                                                                                        )

                                                                                                    [field_count] => 1
                                                                                                    [host_info] => Localhost via UNIX socket
                                                                                                    [info] => 
                                                                                                    [insert_id] => 0
                                                                                                    [server_info] => 5.5.48-cll
                                                                                                    [server_version] => 50548
                                                                                                    [stat] => Uptime: 1034767  Threads: 3  Questions: 7593079  Slow queries: 0  Opens: 29461  Flush tables: 1  Open tables: 379  Queries per second avg: 7.337
                                                                                                    [sqlstate] => 00000
                                                                                                    [protocol_version] => 10
                                                                                                    [thread_id] => 102686
                                                                                                    [warning_count] => 0
                                                                                                )

                                                                                            [nameQuote:protected] => `
                                                                                            [nullDate:protected] => 0000-00-00 00:00:00
                                                                                            [_database:JDatabaseDriver:private] => liberuy2_vxbvn
                                                                                            [count:protected] => 141
                                                                                            [cursor:protected] => 
                                                                                            [debug:protected] => 
                                                                                            [limit:protected] => 0
                                                                                            [log:protected] => Array
                                                                                                (
                                                                                                )

                                                                                            [timings:protected] => Array
                                                                                                (
                                                                                                )

                                                                                            [callStacks:protected] => Array
                                                                                                (
                                                                                                )

                                                                                            [offset:protected] => 0
                                                                                            [options:protected] => Array
                                                                                                (
                                                                                                    [driver] => mysqli
                                                                                                    [host] => localhost
                                                                                                    [user] => liberuy2_lsm
                                                                                                    [password] => Lib3rtyB3ll
                                                                                                    [database] => liberuy2_vxbvn
                                                                                                    [prefix] => vxbvn_
                                                                                                    [select] => 1
                                                                                                    [port] => 3306
                                                                                                    [socket] => 
                                                                                                )

                                                                                            [sql:protected] => JDatabaseQueryMysqli Object
                                                                                                (
                                                                                                    [offset:protected] => 0
                                                                                                    [limit:protected] => 0
                                                                                                    [db:protected] => JDatabaseDriverMysqli Object
 *RECURSION*
                                                                                                    [sql:protected] => 
                                                                                                    [type:protected] => select
                                                                                                    [element:protected] => 
                                                                                                    [select:protected] => JDatabaseQueryElement Object
                                                                                                        (
                                                                                                            [name:protected] => SELECT
                                                                                                            [elements:protected] => Array
                                                                                                                (
                                                                                                                    [0] => id
                                                                                                                )

                                                                                                            [glue:protected] => ,
                                                                                                        )

                                                                                                    [delete:protected] => 
                                                                                                    [update:protected] => 
                                                                                                    [insert:protected] => 
                                                                                                    [from:protected] => JDatabaseQueryElement Object
                                                                                                        (
                                                                                                            [name:protected] => FROM
                                                                                                            [elements:protected] => Array
                                                                                                                (
                                                                                                                    [0] => #__menu
                                                                                                                )

                                                                                                            [glue:protected] => ,
                                                                                                        )

                                                                                                    [join:protected] => 
                                                                                                    [set:protected] => 
                                                                                                    [where:protected] => JDatabaseQueryElement Object
                                                                                                        (
                                                                                                            [name:protected] => WHERE
                                                                                                            [elements:protected] => Array
                                                                                                                (
                                                                                                                    [0] => lft BETWEEN 443 AND 444
                                                                                                                )

                                                                                                            [glue:protected] =>  AND 
                                                                                                        )

                                                                                                    [group:protected] => 
                                                                                                    [having:protected] => 
                                                                                                    [columns:protected] => 
                                                                                                    [values:protected] => 
                                                                                                    [order:protected] => 
                                                                                                    [autoIncrementField:protected] => 
                                                                                                    [call:protected] => 
                                                                                                    [exec:protected] => 
                                                                                                    [union:protected] => 
                                                                                                    [unionAll:protected] => 
                                                                                                )

                                                                                            [tablePrefix:protected] => vxbvn_
                                                                                            [utf:protected] => 1
                                                                                            [utf8mb4:protected] => 1
                                                                                            [errorNum:protected] => 0
                                                                                            [errorMsg:protected] => 
                                                                                            [transactionDepth:protected] => 0
                                                                                            [disconnectHandlers:protected] => Array
                                                                                                (
                                                                                                )

                                                                                        )

                                                                                    [_trackAssets:protected] => 
                                                                                    [_rules:protected] => 
                                                                                    [_locked:protected] => 
                                                                                    [_autoincrement:protected] => 1
                                                                                    [_observers:protected] => JObserverUpdater Object
                                                                                        (
                                                                                            [observers:protected] => Array
                                                                                                (
                                                                                                )

                                                                                            [doCallObservers:protected] => 1
                                                                                        )

                                                                                    [_columnAlias:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [_jsonEncode:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [_errors:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [extension_id] => 
                                                                                    [name] => 
                                                                                    [type] => 
                                                                                    [element] => 
                                                                                    [folder] => 
                                                                                    [client_id] => 
                                                                                    [enabled] => 
                                                                                    [access] => 1
                                                                                    [protected] => 
                                                                                    [manifest_cache] => 
                                                                                    [params] => 
                                                                                    [custom_data] => 
                                                                                    [system_data] => 
                                                                                    [checked_out] => 
                                                                                    [checked_out_time] => 
                                                                                    [ordering] => 
                                                                                    [state] => 
                                                                                )

                                                                            [extensionMessage:protected] => 
                                                                            [manifest] => SimpleXMLElement Object
                                                                                (
                                                                                    [@attributes] => Array
                                                                                        (
                                                                                            [method] => upgrade
                                                                                            [type] => component
                                                                                            [version] => 2.5.0
                                                                                        )

                                                                                    [name] => CjBlog
                                                                                    [creationDate] => 2015-May-30
                                                                                    [author] => Maverick
                                                                                    [authorEmail] => support@corejoomla.com
                                                                                    [authorUrl] => http://www.corejoomla.org
                                                                                    [copyright] => Copyright corejoomla.com. All rights reserved.
                                                                                    [license] => http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
                                                                                    [version] => 1.4.2
                                                                                    [description] => CjBlog - Simple yet powerful blogging platform for Joomla!
                                                                                    [install] => SimpleXMLElement Object
                                                                                        (
                                                                                            [sql] => SimpleXMLElement Object
                                                                                                (
                                                                                                    [file] => sql/install.mysql.utf8.sql
                                                                                                )

                                                                                        )

                                                                                    [files] => SimpleXMLElement Object
                                                                                        (
                                                                                            [@attributes] => Array
                                                                                                (
                                                                                                    [folder] => site
                                                                                                )

                                                                                            [filename] => Array
                                                                                                (
                                                                                                    [0] => index.html
                                                                                                    [1] => cjblog.php
                                                                                                    [2] => controller.php
                                                                                                    [3] => router.php
                                                                                                    [4] => api.php
                                                                                                )

                                                                                            [folder] => Array
                                                                                                (
                                                                                                    [0] => controllers
                                                                                                    [1] => models
                                                                                                    [2] => views
                                                                                                    [3] => helpers
                                                                                                    [4] => layouts
                                                                                                )

                                                                                        )

                                                                                    [media] => SimpleXMLElement Object
                                                                                        (
                                                                                            [@attributes] => Array
                                                                                                (
                                                                                                    [destination] => com_cjblog
                                                                                                    [folder] => site/media
                                                                                                )

                                                                                            [filename] => index.html
                                                                                            [folder] => Array
                                                                                                (
                                                                                                    [0] => css
                                                                                                    [1] => images
                                                                                                    [2] => js
                                                                                                )

                                                                                        )

                                                                                    [languages] => SimpleXMLElement Object
                                                                                        (
                                                                                            [@attributes] => Array
                                                                                                (
                                                                                                    [folder] => site
                                                                                                )

                                                                                            [language] => language/en-GB/en-GB.com_cjblog.ini
                                                                                        )

                                                                                    [administration] => SimpleXMLElement Object
                                                                                        (
                                                                                            [menu] => COM_CJBLOG
                                                                                            [submenu] => SimpleXMLElement Object
                                                                                                (
                                                                                                    [menu] => Array
                                                                                                        (
                                                                                                            [0] => COM_CJBLOG_CONTROL_PANEL
                                                                                                            [1] => COM_CJBLOG_BADGES
                                                                                                            [2] => COM_CJBLOG_BADGE_RULES
                                                                                                            [3] => COM_CJBLOG_BADGE_ACTIVITY
                                                                                                            [4] => COM_CJBLOG_POINTS
                                                                                                            [5] => COM_CJBLOG_POINT_RULES
                                                                                                            [6] => COM_CJBLOG_USERS
                                                                                                        )

                                                                                                )

                                                                                            [files] => SimpleXMLElement Object
                                                                                                (
                                                                                                    [@attributes] => Array
                                                                                                        (
                                                                                                            [folder] => admin
                                                                                                        )

                                                                                                    [filename] => Array
                                                                                                        (
                                                                                                            [0] => index.html
                                                                                                            [1] => access.xml
                                                                                                            [2] => config.xml
                                                                                                            [3] => cjblog.php
                                                                                                        )

                                                                                                    [folder] => Array
                                                                                                        (
                                                                                                            [0] => assets
                                                                                                            [1] => controllers
                                                                                                            [2] => helpers
                                                                                                            [3] => models
                                                                                                            [4] => sql
                                                                                                            [5] => views
                                                                                                        )

                                                                                                )

                                                                                            [languages] => SimpleXMLElement Object
                                                                                                (
                                                                                                    [@attributes] => Array
                                                                                                        (
                                                                                                            [folder] => admin
                                                                                                        )

                                                                                                    [language] => Array
                                                                                                        (
                                                                                                            [0] => language/en-GB/en-GB.com_cjblog.ini
                                                                                                            [1] => language/en-GB/en-GB.com_cjblog.sys.ini
                                                                                                        )

                                                                                                )

                                                                                        )

                                                                                    [scriptfile] => script.php
                                                                                    [updateservers] => SimpleXMLElement Object
                                                                                        (
                                                                                            [server] => http://www.corejoomla.com/media/autoupdates/com_cjblog.xml
                                                                                        )

                                                                                )

                                                                            [manifest_script:protected] => 
                                                                            [name:protected] => 
                                                                            [route:protected] => install
                                                                            [supportsDiscoverInstall:protected] => 1
                                                                            [type:protected] => template
                                                                            [parent:protected] => JInstaller Object
 *RECURSION*
                                                                            [db:protected] => JDatabaseDriverMysqli Object
                                                                                (
                                                                                    [name] => mysqli
                                                                                    [serverType] => mysql
                                                                                    [connection:protected] => mysqli Object
                                                                                        (
                                                                                            [affected_rows] => -1
                                                                                            [client_info] => 5.5.36
                                                                                            [client_version] => 50536
                                                                                            [connect_errno] => 0
                                                                                            [connect_error] => 
                                                                                            [errno] => 0
                                                                                            [error] => 
                                                                                            [error_list] => Array
                                                                                                (
                                                                                                )

                                                                                            [field_count] => 1
                                                                                            [host_info] => Localhost via UNIX socket
                                                                                            [info] => 
                                                                                            [insert_id] => 0
                                                                                            [server_info] => 5.5.48-cll
                                                                                            [server_version] => 50548
                                                                                            [stat] => Uptime: 1034767  Threads: 3  Questions: 7593080  Slow queries: 0  Opens: 29461  Flush tables: 1  Open tables: 379  Queries per second avg: 7.337
                                                                                            [sqlstate] => 00000
                                                                                            [protocol_version] => 10
                                                                                            [thread_id] => 102686
                                                                                            [warning_count] => 0
                                                                                        )

                                                                                    [nameQuote:protected] => `
                                                                                    [nullDate:protected] => 0000-00-00 00:00:00
                                                                                    [_database:JDatabaseDriver:private] => liberuy2_vxbvn
                                                                                    [count:protected] => 141
                                                                                    [cursor:protected] => 
                                                                                    [debug:protected] => 
                                                                                    [limit:protected] => 0
                                                                                    [log:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [timings:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [callStacks:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [offset:protected] => 0
                                                                                    [options:protected] => Array
                                                                                        (
                                                                                            [driver] => mysqli
                                                                                            [host] => localhost
                                                                                            [user] => liberuy2_lsm
                                                                                            [password] => Lib3rtyB3ll
                                                                                            [database] => liberuy2_vxbvn
                                                                                            [prefix] => vxbvn_
                                                                                            [select] => 1
                                                                                            [port] => 3306
                                                                                            [socket] => 
                                                                                        )

                                                                                    [sql:protected] => JDatabaseQueryMysqli Object
                                                                                        (
                                                                                            [offset:protected] => 0
                                                                                            [limit:protected] => 0
                                                                                            [db:protected] => JDatabaseDriverMysqli Object
 *RECURSION*
                                                                                            [sql:protected] => 
                                                                                            [type:protected] => select
                                                                                            [element:protected] => 
                                                                                            [select:protected] => JDatabaseQueryElement Object
                                                                                                (
                                                                                                    [name:protected] => SELECT
                                                                                                    [elements:protected] => Array
                                                                                                        (
                                                                                                            [0] => id
                                                                                                        )

                                                                                                    [glue:protected] => ,
                                                                                                )

                                                                                            [delete:protected] => 
                                                                                            [update:protected] => 
                                                                                            [insert:protected] => 
                                                                                            [from:protected] => JDatabaseQueryElement Object
                                                                                                (
                                                                                                    [name:protected] => FROM
                                                                                                    [elements:protected] => Array
                                                                                                        (
                                                                                                            [0] => #__menu
                                                                                                        )

                                                                                                    [glue:protected] => ,
                                                                                                )

                                                                                            [join:protected] => 
                                                                                            [set:protected] => 
                                                                                            [where:protected] => JDatabaseQueryElement Object
                                                                                                (
                                                                                                    [name:protected] => WHERE
                                                                                                    [elements:protected] => Array
                                                                                                        (
                                                                                                            [0] => lft BETWEEN 443 AND 444
                                                                                                        )

                                                                                                    [glue:protected] =>  AND 
                                                                                                )

                                                                                            [group:protected] => 
                                                                                            [having:protected] => 
                                                                                            [columns:protected] => 
                                                                                            [values:protected] => 
                                                                                            [order:protected] => 
                                                                                            [autoIncrementField:protected] => 
                                                                                            [call:protected] => 
                                                                                            [exec:protected] => 
                                                                                            [union:protected] => 
                                                                                            [unionAll:protected] => 
                                                                                        )

                                                                                    [tablePrefix:protected] => vxbvn_
                                                                                    [utf:protected] => 1
                                                                                    [utf8mb4:protected] => 1
                                                                                    [errorNum:protected] => 0
                                                                                    [errorMsg:protected] => 
                                                                                    [transactionDepth:protected] => 0
                                                                                    [disconnectHandlers:protected] => Array
                                                                                        (
                                                                                        )

                                                                                )

                                                                            [_errors:protected] => Array
                                                                                (
                                                                                )

                                                                        )

                                                                    [file] => JInstallerAdapterFile Object
                                                                        (
                                                                            [scriptElement:protected] => 
                                                                            [supportsDiscoverInstall:protected] => 
                                                                            [currentExtensionId:protected] => 
                                                                            [element:protected] => 
                                                                            [extension:protected] => JTableExtension Object
                                                                                (
                                                                                    [_tbl:protected] => #__extensions
                                                                                    [_tbl_key:protected] => extension_id
                                                                                    [_tbl_keys:protected] => Array
                                                                                        (
                                                                                            [0] => extension_id
                                                                                        )

                                                                                    [_db:protected] => JDatabaseDriverMysqli Object
                                                                                        (
                                                                                            [name] => mysqli
                                                                                            [serverType] => mysql
                                                                                            [connection:protected] => mysqli Object
                                                                                                (
                                                                                                    [affected_rows] => -1
                                                                                                    [client_info] => 5.5.36
                                                                                                    [client_version] => 50536
                                                                                                    [connect_errno] => 0
                                                                                                    [connect_error] => 
                                                                                                    [errno] => 0
                                                                                                    [error] => 
                                                                                                    [error_list] => Array
                                                                                                        (
                                                                                                        )

                                                                                                    [field_count] => 1
                                                                                                    [host_info] => Localhost via UNIX socket
                                                                                                    [info] => 
                                                                                                    [insert_id] => 0
                                                                                                    [server_info] => 5.5.48-cll
                                                                                                    [server_version] => 50548
                                                                                                    [stat] => Uptime: 1034767  Threads: 3  Questions: 7593081  Slow queries: 0  Opens: 29461  Flush tables: 1  Open tables: 379  Queries per second avg: 7.337
                                                                                                    [sqlstate] => 00000
                                                                                                    [protocol_version] => 10
                                                                                                    [thread_id] => 102686
                                                                                                    [warning_count] => 0
                                                                                                )

                                                                                            [nameQuote:protected] => `
                                                                                            [nullDate:protected] => 0000-00-00 00:00:00
                                                                                            [_database:JDatabaseDriver:private] => liberuy2_vxbvn
                                                                                            [count:protected] => 141
                                                                                            [cursor:protected] => 
                                                                                            [debug:protected] => 
                                                                                            [limit:protected] => 0
                                                                                            [log:protected] => Array
                                                                                                (
                                                                                                )

                                                                                            [timings:protected] => Array
                                                                                                (
                                                                                                )

                                                                                            [callStacks:protected] => Array
                                                                                                (
                                                                                                )

                                                                                            [offset:protected] => 0
                                                                                            [options:protected] => Array
                                                                                                (
                                                                                                    [driver] => mysqli
                                                                                                    [host] => localhost
                                                                                                    [user] => liberuy2_lsm
                                                                                                    [password] => Lib3rtyB3ll
                                                                                                    [database] => liberuy2_vxbvn
                                                                                                    [prefix] => vxbvn_
                                                                                                    [select] => 1
                                                                                                    [port] => 3306
                                                                                                    [socket] => 
                                                                                                )

                                                                                            [sql:protected] => JDatabaseQueryMysqli Object
                                                                                                (
                                                                                                    [offset:protected] => 0
                                                                                                    [limit:protected] => 0
                                                                                                    [db:protected] => JDatabaseDriverMysqli Object
 *RECURSION*
                                                                                                    [sql:protected] => 
                                                                                                    [type:protected] => select
                                                                                                    [element:protected] => 
                                                                                                    [select:protected] => JDatabaseQueryElement Object
                                                                                                        (
                                                                                                            [name:protected] => SELECT
                                                                                                            [elements:protected] => Array
                                                                                                                (
                                                                                                                    [0] => id
                                                                                                                )

                                                                                                            [glue:protected] => ,
                                                                                                        )

                                                                                                    [delete:protected] => 
                                                                                                    [update:protected] => 
                                                                                                    [insert:protected] => 
                                                                                                    [from:protected] => JDatabaseQueryElement Object
                                                                                                        (
                                                                                                            [name:protected] => FROM
                                                                                                            [elements:protected] => Array
                                                                                                                (
                                                                                                                    [0] => #__menu
                                                                                                                )

                                                                                                            [glue:protected] => ,
                                                                                                        )

                                                                                                    [join:protected] => 
                                                                                                    [set:protected] => 
                                                                                                    [where:protected] => JDatabaseQueryElement Object
                                                                                                        (
                                                                                                            [name:protected] => WHERE
                                                                                                            [elements:protected] => Array
                                                                                                                (
                                                                                                                    [0] => lft BETWEEN 443 AND 444
                                                                                                                )

                                                                                                            [glue:protected] =>  AND 
                                                                                                        )

                                                                                                    [group:protected] => 
                                                                                                    [having:protected] => 
                                                                                                    [columns:protected] => 
                                                                                                    [values:protected] => 
                                                                                                    [order:protected] => 
                                                                                                    [autoIncrementField:protected] => 
                                                                                                    [call:protected] => 
                                                                                                    [exec:protected] => 
                                                                                                    [union:protected] => 
                                                                                                    [unionAll:protected] => 
                                                                                                )

                                                                                            [tablePrefix:protected] => vxbvn_
                                                                                            [utf:protected] => 1
                                                                                            [utf8mb4:protected] => 1
                                                                                            [errorNum:protected] => 0
                                                                                            [errorMsg:protected] => 
                                                                                            [transactionDepth:protected] => 0
                                                                                            [disconnectHandlers:protected] => Array
                                                                                                (
                                                                                                )

                                                                                        )

                                                                                    [_trackAssets:protected] => 
                                                                                    [_rules:protected] => 
                                                                                    [_locked:protected] => 
                                                                                    [_autoincrement:protected] => 1
                                                                                    [_observers:protected] => JObserverUpdater Object
                                                                                        (
                                                                                            [observers:protected] => Array
                                                                                                (
                                                                                                )

                                                                                            [doCallObservers:protected] => 1
                                                                                        )

                                                                                    [_columnAlias:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [_jsonEncode:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [_errors:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [extension_id] => 
                                                                                    [name] => 
                                                                                    [type] => 
                                                                                    [element] => 
                                                                                    [folder] => 
                                                                                    [client_id] => 
                                                                                    [enabled] => 
                                                                                    [access] => 1
                                                                                    [protected] => 
                                                                                    [manifest_cache] => 
                                                                                    [params] => 
                                                                                    [custom_data] => 
                                                                                    [system_data] => 
                                                                                    [checked_out] => 
                                                                                    [checked_out_time] => 
                                                                                    [ordering] => 
                                                                                    [state] => 
                                                                                )

                                                                            [extensionMessage:protected] => 
                                                                            [manifest] => SimpleXMLElement Object
                                                                                (
                                                                                    [@attributes] => Array
                                                                                        (
                                                                                            [method] => upgrade
                                                                                            [type] => component
                                                                                            [version] => 2.5.0
                                                                                        )

                                                                                    [name] => CjBlog
                                                                                    [creationDate] => 2015-May-30
                                                                                    [author] => Maverick
                                                                                    [authorEmail] => support@corejoomla.com
                                                                                    [authorUrl] => http://www.corejoomla.org
                                                                                    [copyright] => Copyright corejoomla.com. All rights reserved.
                                                                                    [license] => http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
                                                                                    [version] => 1.4.2
                                                                                    [description] => CjBlog - Simple yet powerful blogging platform for Joomla!
                                                                                    [install] => SimpleXMLElement Object
                                                                                        (
                                                                                            [sql] => SimpleXMLElement Object
                                                                                                (
                                                                                                    [file] => sql/install.mysql.utf8.sql
                                                                                                )

                                                                                        )

                                                                                    [files] => SimpleXMLElement Object
                                                                                        (
                                                                                            [@attributes] => Array
                                                                                                (
                                                                                                    [folder] => site
                                                                                                )

                                                                                            [filename] => Array
                                                                                                (
                                                                                                    [0] => index.html
                                                                                                    [1] => cjblog.php
                                                                                                    [2] => controller.php
                                                                                                    [3] => router.php
                                                                                                    [4] => api.php
                                                                                                )

                                                                                            [folder] => Array
                                                                                                (
                                                                                                    [0] => controllers
                                                                                                    [1] => models
                                                                                                    [2] => views
                                                                                                    [3] => helpers
                                                                                                    [4] => layouts
                                                                                                )

                                                                                        )

                                                                                    [media] => SimpleXMLElement Object
                                                                                        (
                                                                                            [@attributes] => Array
                                                                                                (
                                                                                                    [destination] => com_cjblog
                                                                                                    [folder] => site/media
                                                                                                )

                                                                                            [filename] => index.html
                                                                                            [folder] => Array
                                                                                                (
                                                                                                    [0] => css
                                                                                                    [1] => images
                                                                                                    [2] => js
                                                                                                )

                                                                                        )

                                                                                    [languages] => SimpleXMLElement Object
                                                                                        (
                                                                                            [@attributes] => Array
                                                                                                (
                                                                                                    [folder] => site
                                                                                                )

                                                                                            [language] => language/en-GB/en-GB.com_cjblog.ini
                                                                                        )

                                                                                    [administration] => SimpleXMLElement Object
                                                                                        (
                                                                                            [menu] => COM_CJBLOG
                                                                                            [submenu] => SimpleXMLElement Object
                                                                                                (
                                                                                                    [menu] => Array
                                                                                                        (
                                                                                                            [0] => COM_CJBLOG_CONTROL_PANEL
                                                                                                            [1] => COM_CJBLOG_BADGES
                                                                                                            [2] => COM_CJBLOG_BADGE_RULES
                                                                                                            [3] => COM_CJBLOG_BADGE_ACTIVITY
                                                                                                            [4] => COM_CJBLOG_POINTS
                                                                                                            [5] => COM_CJBLOG_POINT_RULES
                                                                                                            [6] => COM_CJBLOG_USERS
                                                                                                        )

                                                                                                )

                                                                                            [files] => SimpleXMLElement Object
                                                                                                (
                                                                                                    [@attributes] => Array
                                                                                                        (
                                                                                                            [folder] => admin
                                                                                                        )

                                                                                                    [filename] => Array
                                                                                                        (
                                                                                                            [0] => index.html
                                                                                                            [1] => access.xml
                                                                                                            [2] => config.xml
                                                                                                            [3] => cjblog.php
                                                                                                        )

                                                                                                    [folder] => Array
                                                                                                        (
                                                                                                            [0] => assets
                                                                                                            [1] => controllers
                                                                                                            [2] => helpers
                                                                                                            [3] => models
                                                                                                            [4] => sql
                                                                                                            [5] => views
                                                                                                        )

                                                                                                )

                                                                                            [languages] => SimpleXMLElement Object
                                                                                                (
                                                                                                    [@attributes] => Array
                                                                                                        (
                                                                                                            [folder] => admin
                                                                                                        )

                                                                                                    [language] => Array
                                                                                                        (
                                                                                                            [0] => language/en-GB/en-GB.com_cjblog.ini
                                                                                                            [1] => language/en-GB/en-GB.com_cjblog.sys.ini
                                                                                                        )

                                                                                                )

                                                                                        )

                                                                                    [scriptfile] => script.php
                                                                                    [updateservers] => SimpleXMLElement Object
                                                                                        (
                                                                                            [server] => http://www.corejoomla.com/media/autoupdates/com_cjblog.xml
                                                                                        )

                                                                                )

                                                                            [manifest_script:protected] => 
                                                                            [name:protected] => 
                                                                            [route:protected] => install
                                                                            [type:protected] => file
                                                                            [parent:protected] => JInstaller Object
 *RECURSION*
                                                                            [db:protected] => JDatabaseDriverMysqli Object
                                                                                (
                                                                                    [name] => mysqli
                                                                                    [serverType] => mysql
                                                                                    [connection:protected] => mysqli Object
                                                                                        (
                                                                                            [affected_rows] => -1
                                                                                            [client_info] => 5.5.36
                                                                                            [client_version] => 50536
                                                                                            [connect_errno] => 0
                                                                                            [connect_error] => 
                                                                                            [errno] => 0
                                                                                            [error] => 
                                                                                            [error_list] => Array
                                                                                                (
                                                                                                )

                                                                                            [field_count] => 1
                                                                                            [host_info] => Localhost via UNIX socket
                                                                                            [info] => 
                                                                                            [insert_id] => 0
                                                                                            [server_info] => 5.5.48-cll
                                                                                            [server_version] => 50548
                                                                                            [stat] => Uptime: 1034767  Threads: 3  Questions: 7593082  Slow queries: 0  Opens: 29461  Flush tables: 1  Open tables: 379  Queries per second avg: 7.337
                                                                                            [sqlstate] => 00000
                                                                                            [protocol_version] => 10
                                                                                            [thread_id] => 102686
                                                                                            [warning_count] => 0
                                                                                        )

                                                                                    [nameQuote:protected] => `
                                                                                    [nullDate:protected] => 0000-00-00 00:00:00
                                                                                    [_database:JDatabaseDriver:private] => liberuy2_vxbvn
                                                                                    [count:protected] => 141
                                                                                    [cursor:protected] => 
                                                                                    [debug:protected] => 
                                                                                    [limit:protected] => 0
                                                                                    [log:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [timings:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [callStacks:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [offset:protected] => 0
                                                                                    [options:protected] => Array
                                                                                        (
                                                                                            [driver] => mysqli
                                                                                            [host] => localhost
                                                                                            [user] => liberuy2_lsm
                                                                                            [password] => Lib3rtyB3ll
                                                                                            [database] => liberuy2_vxbvn
                                                                                            [prefix] => vxbvn_
                                                                                            [select] => 1
                                                                                            [port] => 3306
                                                                                            [socket] => 
                                                                                        )

                                                                                    [sql:protected] => JDatabaseQueryMysqli Object
                                                                                        (
                                                                                            [offset:protected] => 0
                                                                                            [limit:protected] => 0
                                                                                            [db:protected] => JDatabaseDriverMysqli Object
 *RECURSION*
                                                                                            [sql:protected] => 
                                                                                            [type:protected] => select
                                                                                            [element:protected] => 
                                                                                            [select:protected] => JDatabaseQueryElement Object
                                                                                                (
                                                                                                    [name:protected] => SELECT
                                                                                                    [elements:protected] => Array
                                                                                                        (
                                                                                                            [0] => id
                                                                                                        )

                                                                                                    [glue:protected] => ,
                                                                                                )

                                                                                            [delete:protected] => 
                                                                                            [update:protected] => 
                                                                                            [insert:protected] => 
                                                                                            [from:protected] => JDatabaseQueryElement Object
                                                                                                (
                                                                                                    [name:protected] => FROM
                                                                                                    [elements:protected] => Array
                                                                                                        (
                                                                                                            [0] => #__menu
                                                                                                        )

                                                                                                    [glue:protected] => ,
                                                                                                )

                                                                                            [join:protected] => 
                                                                                            [set:protected] => 
                                                                                            [where:protected] => JDatabaseQueryElement Object
                                                                                                (
                                                                                                    [name:protected] => WHERE
                                                                                                    [elements:protected] => Array
                                                                                                        (
                                                                                                            [0] => lft BETWEEN 443 AND 444
                                                                                                        )

                                                                                                    [glue:protected] =>  AND 
                                                                                                )

                                                                                            [group:protected] => 
                                                                                            [having:protected] => 
                                                                                            [columns:protected] => 
                                                                                            [values:protected] => 
                                                                                            [order:protected] => 
                                                                                            [autoIncrementField:protected] => 
                                                                                            [call:protected] => 
                                                                                            [exec:protected] => 
                                                                                            [union:protected] => 
                                                                                            [unionAll:protected] => 
                                                                                        )

                                                                                    [tablePrefix:protected] => vxbvn_
                                                                                    [utf:protected] => 1
                                                                                    [utf8mb4:protected] => 1
                                                                                    [errorNum:protected] => 0
                                                                                    [errorMsg:protected] => 
                                                                                    [transactionDepth:protected] => 0
                                                                                    [disconnectHandlers:protected] => Array
                                                                                        (
                                                                                        )

                                                                                )

                                                                            [_errors:protected] => Array
                                                                                (
                                                                                )

                                                                        )

                                                                    [plugin] => JInstallerAdapterPlugin Object
                                                                        (
                                                                            [scriptElement:protected] => 
                                                                            [oldFiles:protected] => 
                                                                            [currentExtensionId:protected] => 
                                                                            [element:protected] => 
                                                                            [extension:protected] => JTableExtension Object
                                                                                (
                                                                                    [_tbl:protected] => #__extensions
                                                                                    [_tbl_key:protected] => extension_id
                                                                                    [_tbl_keys:protected] => Array
                                                                                        (
                                                                                            [0] => extension_id
                                                                                        )

                                                                                    [_db:protected] => JDatabaseDriverMysqli Object
                                                                                        (
                                                                                            [name] => mysqli
                                                                                            [serverType] => mysql
                                                                                            [connection:protected] => mysqli Object
                                                                                                (
                                                                                                    [affected_rows] => -1
                                                                                                    [client_info] => 5.5.36
                                                                                                    [client_version] => 50536
                                                                                                    [connect_errno] => 0
                                                                                                    [connect_error] => 
                                                                                                    [errno] => 0
                                                                                                    [error] => 
                                                                                                    [error_list] => Array
                                                                                                        (
                                                                                                        )

                                                                                                    [field_count] => 1
                                                                                                    [host_info] => Localhost via UNIX socket
                                                                                                    [info] => 
                                                                                                    [insert_id] => 0
                                                                                                    [server_info] => 5.5.48-cll
                                                                                                    [server_version] => 50548
                                                                                                    [stat] => Uptime: 1034767  Threads: 3  Questions: 7593083  Slow queries: 0  Opens: 29461  Flush tables: 1  Open tables: 379  Queries per second avg: 7.337
                                                                                                    [sqlstate] => 00000
                                                                                                    [protocol_version] => 10
                                                                                                    [thread_id] => 102686
                                                                                                    [warning_count] => 0
                                                                                                )

                                                                                            [nameQuote:protected] => `
                                                                                            [nullDate:protected] => 0000-00-00 00:00:00
                                                                                            [_database:JDatabaseDriver:private] => liberuy2_vxbvn
                                                                                            [count:protected] => 141
                                                                                            [cursor:protected] => 
                                                                                            [debug:protected] => 
                                                                                            [limit:protected] => 0
                                                                                            [log:protected] => Array
                                                                                                (
                                                                                                )

                                                                                            [timings:protected] => Array
                                                                                                (
                                                                                                )

                                                                                            [callStacks:protected] => Array
                                                                                                (
                                                                                                )

                                                                                            [offset:protected] => 0
                                                                                            [options:protected] => Array
                                                                                                (
                                                                                                    [driver] => mysqli
                                                                                                    [host] => localhost
                                                                                                    [user] => liberuy2_lsm
                                                                                                    [password] => Lib3rtyB3ll
                                                                                                    [database] => liberuy2_vxbvn
                                                                                                    [prefix] => vxbvn_
                                                                                                    [select] => 1
                                                                                                    [port] => 3306
                                                                                                    [socket] => 
                                                                                                )

                                                                                            [sql:protected] => JDatabaseQueryMysqli Object
                                                                                                (
                                                                                                    [offset:protected] => 0
                                                                                                    [limit:protected] => 0
                                                                                                    [db:protected] => JDatabaseDriverMysqli Object
 *RECURSION*
                                                                                                    [sql:protected] => 
                                                                                                    [type:protected] => select
                                                                                                    [element:protected] => 
                                                                                                    [select:protected] => JDatabaseQueryElement Object
                                                                                                        (
                                                                                                            [name:protected] => SELECT
                                                                                                            [elements:protected] => Array
                                                                                                                (
                                                                                                                    [0] => id
                                                                                                                )

                                                                                                            [glue:protected] => ,
                                                                                                        )

                                                                                                    [delete:protected] => 
                                                                                                    [update:protected] => 
                                                                                                    [insert:protected] => 
                                                                                                    [from:protected] => JDatabaseQueryElement Object
                                                                                                        (
                                                                                                            [name:protected] => FROM
                                                                                                            [elements:protected] => Array
                                                                                                                (
                                                                                                                    [0] => #__menu
                                                                                                                )

                                                                                                            [glue:protected] => ,
                                                                                                        )

                                                                                                    [join:protected] => 
                                                                                                    [set:protected] => 
                                                                                                    [where:protected] => JDatabaseQueryElement Object
                                                                                                        (
                                                                                                            [name:protected] => WHERE
                                                                                                            [elements:protected] => Array
                                                                                                                (
                                                                                                                    [0] => lft BETWEEN 443 AND 444
                                                                                                                )

                                                                                                            [glue:protected] =>  AND 
                                                                                                        )

                                                                                                    [group:protected] => 
                                                                                                    [having:protected] => 
                                                                                                    [columns:protected] => 
                                                                                                    [values:protected] => 
                                                                                                    [order:protected] => 
                                                                                                    [autoIncrementField:protected] => 
                                                                                                    [call:protected] => 
                                                                                                    [exec:protected] => 
                                                                                                    [union:protected] => 
                                                                                                    [unionAll:protected] => 
                                                                                                )

                                                                                            [tablePrefix:protected] => vxbvn_
                                                                                            [utf:protected] => 1
                                                                                            [utf8mb4:protected] => 1
                                                                                            [errorNum:protected] => 0
                                                                                            [errorMsg:protected] => 
                                                                                            [transactionDepth:protected] => 0
                                                                                            [disconnectHandlers:protected] => Array
                                                                                                (
                                                                                                )

                                                                                        )

                                                                                    [_trackAssets:protected] => 
                                                                                    [_rules:protected] => 
                                                                                    [_locked:protected] => 
                                                                                    [_autoincrement:protected] => 1
                                                                                    [_observers:protected] => JObserverUpdater Object
                                                                                        (
                                                                                            [observers:protected] => Array
                                                                                                (
                                                                                                )

                                                                                            [doCallObservers:protected] => 1
                                                                                        )

                                                                                    [_columnAlias:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [_jsonEncode:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [_errors:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [extension_id] => 
                                                                                    [name] => 
                                                                                    [type] => 
                                                                                    [element] => 
                                                                                    [folder] => 
                                                                                    [client_id] => 
                                                                                    [enabled] => 
                                                                                    [access] => 1
                                                                                    [protected] => 
                                                                                    [manifest_cache] => 
                                                                                    [params] => 
                                                                                    [custom_data] => 
                                                                                    [system_data] => 
                                                                                    [checked_out] => 
                                                                                    [checked_out_time] => 
                                                                                    [ordering] => 
                                                                                    [state] => 
                                                                                )

                                                                            [extensionMessage:protected] => 
                                                                            [manifest] => SimpleXMLElement Object
                                                                                (
                                                                                    [@attributes] => Array
                                                                                        (
                                                                                            [method] => upgrade
                                                                                            [type] => component
                                                                                            [version] => 2.5.0
                                                                                        )

                                                                                    [name] => CjBlog
                                                                                    [creationDate] => 2015-May-30
                                                                                    [author] => Maverick
                                                                                    [authorEmail] => support@corejoomla.com
                                                                                    [authorUrl] => http://www.corejoomla.org
                                                                                    [copyright] => Copyright corejoomla.com. All rights reserved.
                                                                                    [license] => http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
                                                                                    [version] => 1.4.2
                                                                                    [description] => CjBlog - Simple yet powerful blogging platform for Joomla!
                                                                                    [install] => SimpleXMLElement Object
                                                                                        (
                                                                                            [sql] => SimpleXMLElement Object
                                                                                                (
                                                                                                    [file] => sql/install.mysql.utf8.sql
                                                                                                )

                                                                                        )

                                                                                    [files] => SimpleXMLElement Object
                                                                                        (
                                                                                            [@attributes] => Array
                                                                                                (
                                                                                                    [folder] => site
                                                                                                )

                                                                                            [filename] => Array
                                                                                                (
                                                                                                    [0] => index.html
                                                                                                    [1] => cjblog.php
                                                                                                    [2] => controller.php
                                                                                                    [3] => router.php
                                                                                                    [4] => api.php
                                                                                                )

                                                                                            [folder] => Array
                                                                                                (
                                                                                                    [0] => controllers
                                                                                                    [1] => models
                                                                                                    [2] => views
                                                                                                    [3] => helpers
                                                                                                    [4] => layouts
                                                                                                )

                                                                                        )

                                                                                    [media] => SimpleXMLElement Object
                                                                                        (
                                                                                            [@attributes] => Array
                                                                                                (
                                                                                                    [destination] => com_cjblog
                                                                                                    [folder] => site/media
                                                                                                )

                                                                                            [filename] => index.html
                                                                                            [folder] => Array
                                                                                                (
                                                                                                    [0] => css
                                                                                                    [1] => images
                                                                                                    [2] => js
                                                                                                )

                                                                                        )

                                                                                    [languages] => SimpleXMLElement Object
                                                                                        (
                                                                                            [@attributes] => Array
                                                                                                (
                                                                                                    [folder] => site
                                                                                                )

                                                                                            [language] => language/en-GB/en-GB.com_cjblog.ini
                                                                                        )

                                                                                    [administration] => SimpleXMLElement Object
                                                                                        (
                                                                                            [menu] => COM_CJBLOG
                                                                                            [submenu] => SimpleXMLElement Object
                                                                                                (
                                                                                                    [menu] => Array
                                                                                                        (
                                                                                                            [0] => COM_CJBLOG_CONTROL_PANEL
                                                                                                            [1] => COM_CJBLOG_BADGES
                                                                                                            [2] => COM_CJBLOG_BADGE_RULES
                                                                                                            [3] => COM_CJBLOG_BADGE_ACTIVITY
                                                                                                            [4] => COM_CJBLOG_POINTS
                                                                                                            [5] => COM_CJBLOG_POINT_RULES
                                                                                                            [6] => COM_CJBLOG_USERS
                                                                                                        )

                                                                                                )

                                                                                            [files] => SimpleXMLElement Object
                                                                                                (
                                                                                                    [@attributes] => Array
                                                                                                        (
                                                                                                            [folder] => admin
                                                                                                        )

                                                                                                    [filename] => Array
                                                                                                        (
                                                                                                            [0] => index.html
                                                                                                            [1] => access.xml
                                                                                                            [2] => config.xml
                                                                                                            [3] => cjblog.php
                                                                                                        )

                                                                                                    [folder] => Array
                                                                                                        (
                                                                                                            [0] => assets
                                                                                                            [1] => controllers
                                                                                                            [2] => helpers
                                                                                                            [3] => models
                                                                                                            [4] => sql
                                                                                                            [5] => views
                                                                                                        )

                                                                                                )

                                                                                            [languages] => SimpleXMLElement Object
                                                                                                (
                                                                                                    [@attributes] => Array
                                                                                                        (
                                                                                                            [folder] => admin
                                                                                                        )

                                                                                                    [language] => Array
                                                                                                        (
                                                                                                            [0] => language/en-GB/en-GB.com_cjblog.ini
                                                                                                            [1] => language/en-GB/en-GB.com_cjblog.sys.ini
                                                                                                        )

                                                                                                )

                                                                                        )

                                                                                    [scriptfile] => script.php
                                                                                    [updateservers] => SimpleXMLElement Object
                                                                                        (
                                                                                            [server] => http://www.corejoomla.com/media/autoupdates/com_cjblog.xml
                                                                                        )

                                                                                )

                                                                            [manifest_script:protected] => 
                                                                            [name:protected] => 
                                                                            [route:protected] => install
                                                                            [supportsDiscoverInstall:protected] => 1
                                                                            [type:protected] => plugin
                                                                            [parent:protected] => JInstaller Object
 *RECURSION*
                                                                            [db:protected] => JDatabaseDriverMysqli Object
                                                                                (
                                                                                    [name] => mysqli
                                                                                    [serverType] => mysql
                                                                                    [connection:protected] => mysqli Object
                                                                                        (
                                                                                            [affected_rows] => -1
                                                                                            [client_info] => 5.5.36
                                                                                            [client_version] => 50536
                                                                                            [connect_errno] => 0
                                                                                            [connect_error] => 
                                                                                            [errno] => 0
                                                                                            [error] => 
                                                                                            [error_list] => Array
                                                                                                (
                                                                                                )

                                                                                            [field_count] => 1
                                                                                            [host_info] => Localhost via UNIX socket
                                                                                            [info] => 
                                                                                            [insert_id] => 0
                                                                                            [server_info] => 5.5.48-cll
                                                                                            [server_version] => 50548
                                                                                            [stat] => Uptime: 1034767  Threads: 3  Questions: 7593084  Slow queries: 0  Opens: 29461  Flush tables: 1  Open tables: 379  Queries per second avg: 7.337
                                                                                            [sqlstate] => 00000
                                                                                            [protocol_version] => 10
                                                                                            [thread_id] => 102686
                                                                                            [warning_count] => 0
                                                                                        )

                                                                                    [nameQuote:protected] => `
                                                                                    [nullDate:protected] => 0000-00-00 00:00:00
                                                                                    [_database:JDatabaseDriver:private] => liberuy2_vxbvn
                                                                                    [count:protected] => 141
                                                                                    [cursor:protected] => 
                                                                                    [debug:protected] => 
                                                                                    [limit:protected] => 0
                                                                                    [log:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [timings:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [callStacks:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [offset:protected] => 0
                                                                                    [options:protected] => Array
                                                                                        (
                                                                                            [driver] => mysqli
                                                                                            [host] => localhost
                                                                                            [user] => liberuy2_lsm
                                                                                            [password] => Lib3rtyB3ll
                                                                                            [database] => liberuy2_vxbvn
                                                                                            [prefix] => vxbvn_
                                                                                            [select] => 1
                                                                                            [port] => 3306
                                                                                            [socket] => 
                                                                                        )

                                                                                    [sql:protected] => JDatabaseQueryMysqli Object
                                                                                        (
                                                                                            [offset:protected] => 0
                                                                                            [limit:protected] => 0
                                                                                            [db:protected] => JDatabaseDriverMysqli Object
 *RECURSION*
                                                                                            [sql:protected] => 
                                                                                            [type:protected] => select
                                                                                            [element:protected] => 
                                                                                            [select:protected] => JDatabaseQueryElement Object
                                                                                                (
                                                                                                    [name:protected] => SELECT
                                                                                                    [elements:protected] => Array
                                                                                                        (
                                                                                                            [0] => id
                                                                                                        )

                                                                                                    [glue:protected] => ,
                                                                                                )

                                                                                            [delete:protected] => 
                                                                                            [update:protected] => 
                                                                                            [insert:protected] => 
                                                                                            [from:protected] => JDatabaseQueryElement Object
                                                                                                (
                                                                                                    [name:protected] => FROM
                                                                                                    [elements:protected] => Array
                                                                                                        (
                                                                                                            [0] => #__menu
                                                                                                        )

                                                                                                    [glue:protected] => ,
                                                                                                )

                                                                                            [join:protected] => 
                                                                                            [set:protected] => 
                                                                                            [where:protected] => JDatabaseQueryElement Object
                                                                                                (
                                                                                                    [name:protected] => WHERE
                                                                                                    [elements:protected] => Array
                                                                                                        (
                                                                                                            [0] => lft BETWEEN 443 AND 444
                                                                                                        )

                                                                                                    [glue:protected] =>  AND 
                                                                                                )

                                                                                            [group:protected] => 
                                                                                            [having:protected] => 
                                                                                            [columns:protected] => 
                                                                                            [values:protected] => 
                                                                                            [order:protected] => 
                                                                                            [autoIncrementField:protected] => 
                                                                                            [call:protected] => 
                                                                                            [exec:protected] => 
                                                                                            [union:protected] => 
                                                                                            [unionAll:protected] => 
                                                                                        )

                                                                                    [tablePrefix:protected] => vxbvn_
                                                                                    [utf:protected] => 1
                                                                                    [utf8mb4:protected] => 1
                                                                                    [errorNum:protected] => 0
                                                                                    [errorMsg:protected] => 
                                                                                    [transactionDepth:protected] => 0
                                                                                    [disconnectHandlers:protected] => Array
                                                                                        (
                                                                                        )

                                                                                )

                                                                            [_errors:protected] => Array
                                                                                (
                                                                                )

                                                                        )

                                                                    [component] => JInstallerAdapterComponent Object
 *RECURSION*
                                                                    [package] => JInstallerAdapterPackage Object
                                                                        (
                                                                            [results:protected] => Array
                                                                                (
                                                                                )

                                                                            [supportsDiscoverInstall:protected] => 
                                                                            [currentExtensionId:protected] => 
                                                                            [element:protected] => 
                                                                            [extension:protected] => JTableExtension Object
                                                                                (
                                                                                    [_tbl:protected] => #__extensions
                                                                                    [_tbl_key:protected] => extension_id
                                                                                    [_tbl_keys:protected] => Array
                                                                                        (
                                                                                            [0] => extension_id
                                                                                        )

                                                                                    [_db:protected] => JDatabaseDriverMysqli Object
                                                                                        (
                                                                                            [name] => mysqli
                                                                                            [serverType] => mysql
                                                                                            [connection:protected] => mysqli Object
                                                                                                (
                                                                                                    [affected_rows] => -1
                                                                                                    [client_info] => 5.5.36
                                                                                                    [client_version] => 50536
                                                                                                    [connect_errno] => 0
                                                                                                    [connect_error] => 
                                                                                                    [errno] => 0
                                                                                                    [error] => 
                                                                                                    [error_list] => Array
                                                                                                        (
                                                                                                        )

                                                                                                    [field_count] => 1
                                                                                                    [host_info] => Localhost via UNIX socket
                                                                                                    [info] => 
                                                                                                    [insert_id] => 0
                                                                                                    [server_info] => 5.5.48-cll
                                                                                                    [server_version] => 50548
                                                                                                    [stat] => Uptime: 1034767  Threads: 3  Questions: 7593085  Slow queries: 0  Opens: 29461  Flush tables: 1  Open tables: 379  Queries per second avg: 7.337
                                                                                                    [sqlstate] => 00000
                                                                                                    [protocol_version] => 10
                                                                                                    [thread_id] => 102686
                                                                                                    [warning_count] => 0
                                                                                                )

                                                                                            [nameQuote:protected] => `
                                                                                            [nullDate:protected] => 0000-00-00 00:00:00
                                                                                            [_database:JDatabaseDriver:private] => liberuy2_vxbvn
                                                                                            [count:protected] => 141
                                                                                            [cursor:protected] => 
                                                                                            [debug:protected] => 
                                                                                            [limit:protected] => 0
                                                                                            [log:protected] => Array
                                                                                                (
                                                                                                )

                                                                                            [timings:protected] => Array
                                                                                                (
                                                                                                )

                                                                                            [callStacks:protected] => Array
                                                                                                (
                                                                                                )

                                                                                            [offset:protected] => 0
                                                                                            [options:protected] => Array
                                                                                                (
                                                                                                    [driver] => mysqli
                                                                                                    [host] => localhost
                                                                                                    [user] => liberuy2_lsm
                                                                                                    [password] => Lib3rtyB3ll
                                                                                                    [database] => liberuy2_vxbvn
                                                                                                    [prefix] => vxbvn_
                                                                                                    [select] => 1
                                                                                                    [port] => 3306
                                                                                                    [socket] => 
                                                                                                )

                                                                                            [sql:protected] => JDatabaseQueryMysqli Object
                                                                                                (
                                                                                                    [offset:protected] => 0
                                                                                                    [limit:protected] => 0
                                                                                                    [db:protected] => JDatabaseDriverMysqli Object
 *RECURSION*
                                                                                                    [sql:protected] => 
                                                                                                    [type:protected] => select
                                                                                                    [element:protected] => 
                                                                                                    [select:protected] => JDatabaseQueryElement Object
                                                                                                        (
                                                                                                            [name:protected] => SELECT
                                                                                                            [elements:protected] => Array
                                                                                                                (
                                                                                                                    [0] => id
                                                                                                                )

                                                                                                            [glue:protected] => ,
                                                                                                        )

                                                                                                    [delete:protected] => 
                                                                                                    [update:protected] => 
                                                                                                    [insert:protected] => 
                                                                                                    [from:protected] => JDatabaseQueryElement Object
                                                                                                        (
                                                                                                            [name:protected] => FROM
                                                                                                            [elements:protected] => Array
                                                                                                                (
                                                                                                                    [0] => #__menu
                                                                                                                )

                                                                                                            [glue:protected] => ,
                                                                                                        )

                                                                                                    [join:protected] => 
                                                                                                    [set:protected] => 
                                                                                                    [where:protected] => JDatabaseQueryElement Object
                                                                                                        (
                                                                                                            [name:protected] => WHERE
                                                                                                            [elements:protected] => Array
                                                                                                                (
                                                                                                                    [0] => lft BETWEEN 443 AND 444
                                                                                                                )

                                                                                                            [glue:protected] =>  AND 
                                                                                                        )

                                                                                                    [group:protected] => 
                                                                                                    [having:protected] => 
                                                                                                    [columns:protected] => 
                                                                                                    [values:protected] => 
                                                                                                    [order:protected] => 
                                                                                                    [autoIncrementField:protected] => 
                                                                                                    [call:protected] => 
                                                                                                    [exec:protected] => 
                                                                                                    [union:protected] => 
                                                                                                    [unionAll:protected] => 
                                                                                                )

                                                                                            [tablePrefix:protected] => vxbvn_
                                                                                            [utf:protected] => 1
                                                                                            [utf8mb4:protected] => 1
                                                                                            [errorNum:protected] => 0
                                                                                            [errorMsg:protected] => 
                                                                                            [transactionDepth:protected] => 0
                                                                                            [disconnectHandlers:protected] => Array
                                                                                                (
                                                                                                )

                                                                                        )

                                                                                    [_trackAssets:protected] => 
                                                                                    [_rules:protected] => 
                                                                                    [_locked:protected] => 
                                                                                    [_autoincrement:protected] => 1
                                                                                    [_observers:protected] => JObserverUpdater Object
                                                                                        (
                                                                                            [observers:protected] => Array
                                                                                                (
                                                                                                )

                                                                                            [doCallObservers:protected] => 1
                                                                                        )

                                                                                    [_columnAlias:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [_jsonEncode:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [_errors:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [extension_id] => 
                                                                                    [name] => 
                                                                                    [type] => 
                                                                                    [element] => 
                                                                                    [folder] => 
                                                                                    [client_id] => 
                                                                                    [enabled] => 
                                                                                    [access] => 1
                                                                                    [protected] => 
                                                                                    [manifest_cache] => 
                                                                                    [params] => 
                                                                                    [custom_data] => 
                                                                                    [system_data] => 
                                                                                    [checked_out] => 
                                                                                    [checked_out_time] => 
                                                                                    [ordering] => 
                                                                                    [state] => 
                                                                                )

                                                                            [extensionMessage:protected] => 
                                                                            [manifest] => SimpleXMLElement Object
                                                                                (
                                                                                    [@attributes] => Array
                                                                                        (
                                                                                            [method] => upgrade
                                                                                            [type] => component
                                                                                            [version] => 2.5.0
                                                                                        )

                                                                                    [name] => CjBlog
                                                                                    [creationDate] => 2015-May-30
                                                                                    [author] => Maverick
                                                                                    [authorEmail] => support@corejoomla.com
                                                                                    [authorUrl] => http://www.corejoomla.org
                                                                                    [copyright] => Copyright corejoomla.com. All rights reserved.
                                                                                    [license] => http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
                                                                                    [version] => 1.4.2
                                                                                    [description] => CjBlog - Simple yet powerful blogging platform for Joomla!
                                                                                    [install] => SimpleXMLElement Object
                                                                                        (
                                                                                            [sql] => SimpleXMLElement Object
                                                                                                (
                                                                                                    [file] => sql/install.mysql.utf8.sql
                                                                                                )

                                                                                        )

                                                                                    [files] => SimpleXMLElement Object
                                                                                        (
                                                                                            [@attributes] => Array
                                                                                                (
                                                                                                    [folder] => site
                                                                                                )

                                                                                            [filename] => Array
                                                                                                (
                                                                                                    [0] => index.html
                                                                                                    [1] => cjblog.php
                                                                                                    [2] => controller.php
                                                                                                    [3] => router.php
                                                                                                    [4] => api.php
                                                                                                )

                                                                                            [folder] => Array
                                                                                                (
                                                                                                    [0] => controllers
                                                                                                    [1] => models
                                                                                                    [2] => views
                                                                                                    [3] => helpers
                                                                                                    [4] => layouts
                                                                                                )

                                                                                        )

                                                                                    [media] => SimpleXMLElement Object
                                                                                        (
                                                                                            [@attributes] => Array
                                                                                                (
                                                                                                    [destination] => com_cjblog
                                                                                                    [folder] => site/media
                                                                                                )

                                                                                            [filename] => index.html
                                                                                            [folder] => Array
                                                                                                (
                                                                                                    [0] => css
                                                                                                    [1] => images
                                                                                                    [2] => js
                                                                                                )

                                                                                        )

                                                                                    [languages] => SimpleXMLElement Object
                                                                                        (
                                                                                            [@attributes] => Array
                                                                                                (
                                                                                                    [folder] => site
                                                                                                )

                                                                                            [language] => language/en-GB/en-GB.com_cjblog.ini
                                                                                        )

                                                                                    [administration] => SimpleXMLElement Object
                                                                                        (
                                                                                            [menu] => COM_CJBLOG
                                                                                            [submenu] => SimpleXMLElement Object
                                                                                                (
                                                                                                    [menu] => Array
                                                                                                        (
                                                                                                            [0] => COM_CJBLOG_CONTROL_PANEL
                                                                                                            [1] => COM_CJBLOG_BADGES
                                                                                                            [2] => COM_CJBLOG_BADGE_RULES
                                                                                                            [3] => COM_CJBLOG_BADGE_ACTIVITY
                                                                                                            [4] => COM_CJBLOG_POINTS
                                                                                                            [5] => COM_CJBLOG_POINT_RULES
                                                                                                            [6] => COM_CJBLOG_USERS
                                                                                                        )

                                                                                                )

                                                                                            [files] => SimpleXMLElement Object
                                                                                                (
                                                                                                    [@attributes] => Array
                                                                                                        (
                                                                                                            [folder] => admin
                                                                                                        )

                                                                                                    [filename] => Array
                                                                                                        (
                                                                                                            [0] => index.html
                                                                                                            [1] => access.xml
                                                                                                            [2] => config.xml
                                                                                                            [3] => cjblog.php
                                                                                                        )

                                                                                                    [folder] => Array
                                                                                                        (
                                                                                                            [0] => assets
                                                                                                            [1] => controllers
                                                                                                            [2] => helpers
                                                                                                            [3] => models
                                                                                                            [4] => sql
                                                                                                            [5] => views
                                                                                                        )

                                                                                                )

                                                                                            [languages] => SimpleXMLElement Object
                                                                                                (
                                                                                                    [@attributes] => Array
                                                                                                        (
                                                                                                            [folder] => admin
                                                                                                        )

                                                                                                    [language] => Array
                                                                                                        (
                                                                                                            [0] => language/en-GB/en-GB.com_cjblog.ini
                                                                                                            [1] => language/en-GB/en-GB.com_cjblog.sys.ini
                                                                                                        )

                                                                                                )

                                                                                        )

                                                                                    [scriptfile] => script.php
                                                                                    [updateservers] => SimpleXMLElement Object
                                                                                        (
                                                                                            [server] => http://www.corejoomla.com/media/autoupdates/com_cjblog.xml
                                                                                        )

                                                                                )

                                                                            [manifest_script:protected] => 
                                                                            [name:protected] => 
                                                                            [route:protected] => install
                                                                            [type:protected] => package
                                                                            [parent:protected] => JInstaller Object
 *RECURSION*
                                                                            [db:protected] => JDatabaseDriverMysqli Object
                                                                                (
                                                                                    [name] => mysqli
                                                                                    [serverType] => mysql
                                                                                    [connection:protected] => mysqli Object
                                                                                        (
                                                                                            [affected_rows] => -1
                                                                                            [client_info] => 5.5.36
                                                                                            [client_version] => 50536
                                                                                            [connect_errno] => 0
                                                                                            [connect_error] => 
                                                                                            [errno] => 0
                                                                                            [error] => 
                                                                                            [error_list] => Array
                                                                                                (
                                                                                                )

                                                                                            [field_count] => 1
                                                                                            [host_info] => Localhost via UNIX socket
                                                                                            [info] => 
                                                                                            [insert_id] => 0
                                                                                            [server_info] => 5.5.48-cll
                                                                                            [server_version] => 50548
                                                                                            [stat] => Uptime: 1034767  Threads: 3  Questions: 7593086  Slow queries: 0  Opens: 29461  Flush tables: 1  Open tables: 379  Queries per second avg: 7.337
                                                                                            [sqlstate] => 00000
                                                                                            [protocol_version] => 10
                                                                                            [thread_id] => 102686
                                                                                            [warning_count] => 0
                                                                                        )

                                                                                    [nameQuote:protected] => `
                                                                                    [nullDate:protected] => 0000-00-00 00:00:00
                                                                                    [_database:JDatabaseDriver:private] => liberuy2_vxbvn
                                                                                    [count:protected] => 141
                                                                                    [cursor:protected] => 
                                                                                    [debug:protected] => 
                                                                                    [limit:protected] => 0
                                                                                    [log:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [timings:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [callStacks:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [offset:protected] => 0
                                                                                    [options:protected] => Array
                                                                                        (
                                                                                            [driver] => mysqli
                                                                                            [host] => localhost
                                                                                            [user] => liberuy2_lsm
                                                                                            [password] => Lib3rtyB3ll
                                                                                            [database] => liberuy2_vxbvn
                                                                                            [prefix] => vxbvn_
                                                                                            [select] => 1
                                                                                            [port] => 3306
                                                                                            [socket] => 
                                                                                        )

                                                                                    [sql:protected] => JDatabaseQueryMysqli Object
                                                                                        (
                                                                                            [offset:protected] => 0
                                                                                            [limit:protected] => 0
                                                                                            [db:protected] => JDatabaseDriverMysqli Object
 *RECURSION*
                                                                                            [sql:protected] => 
                                                                                            [type:protected] => select
                                                                                            [element:protected] => 
                                                                                            [select:protected] => JDatabaseQueryElement Object
                                                                                                (
                                                                                                    [name:protected] => SELECT
                                                                                                    [elements:protected] => Array
                                                                                                        (
                                                                                                            [0] => id
                                                                                                        )

                                                                                                    [glue:protected] => ,
                                                                                                )

                                                                                            [delete:protected] => 
                                                                                            [update:protected] => 
                                                                                            [insert:protected] => 
                                                                                            [from:protected] => JDatabaseQueryElement Object
                                                                                                (
                                                                                                    [name:protected] => FROM
                                                                                                    [elements:protected] => Array
                                                                                                        (
                                                                                                            [0] => #__menu
                                                                                                        )

                                                                                                    [glue:protected] => ,
                                                                                                )

                                                                                            [join:protected] => 
                                                                                            [set:protected] => 
                                                                                            [where:protected] => JDatabaseQueryElement Object
                                                                                                (
                                                                                                    [name:protected] => WHERE
                                                                                                    [elements:protected] => Array
                                                                                                        (
                                                                                                            [0] => lft BETWEEN 443 AND 444
                                                                                                        )

                                                                                                    [glue:protected] =>  AND 
                                                                                                )

                                                                                            [group:protected] => 
                                                                                            [having:protected] => 
                                                                                            [columns:protected] => 
                                                                                            [values:protected] => 
                                                                                            [order:protected] => 
                                                                                            [autoIncrementField:protected] => 
                                                                                            [call:protected] => 
                                                                                            [exec:protected] => 
                                                                                            [union:protected] => 
                                                                                            [unionAll:protected] => 
                                                                                        )

                                                                                    [tablePrefix:protected] => vxbvn_
                                                                                    [utf:protected] => 1
                                                                                    [utf8mb4:protected] => 1
                                                                                    [errorNum:protected] => 0
                                                                                    [errorMsg:protected] => 
                                                                                    [transactionDepth:protected] => 0
                                                                                    [disconnectHandlers:protected] => Array
                                                                                        (
                                                                                        )

                                                                                )

                                                                            [_errors:protected] => Array
                                                                                (
                                                                                )

                                                                        )

                                                                    [module] => JInstallerAdapterModule Object
                                                                        (
                                                                            [clientId:protected] => 
                                                                            [scriptElement:protected] => 
                                                                            [currentExtensionId:protected] => 
                                                                            [element:protected] => 
                                                                            [extension:protected] => JTableExtension Object
                                                                                (
                                                                                    [_tbl:protected] => #__extensions
                                                                                    [_tbl_key:protected] => extension_id
                                                                                    [_tbl_keys:protected] => Array
                                                                                        (
                                                                                            [0] => extension_id
                                                                                        )

                                                                                    [_db:protected] => JDatabaseDriverMysqli Object
                                                                                        (
                                                                                            [name] => mysqli
                                                                                            [serverType] => mysql
                                                                                            [connection:protected] => mysqli Object
                                                                                                (
                                                                                                    [affected_rows] => -1
                                                                                                    [client_info] => 5.5.36
                                                                                                    [client_version] => 50536
                                                                                                    [connect_errno] => 0
                                                                                                    [connect_error] => 
                                                                                                    [errno] => 0
                                                                                                    [error] => 
                                                                                                    [error_list] => Array
                                                                                                        (
                                                                                                        )

                                                                                                    [field_count] => 1
                                                                                                    [host_info] => Localhost via UNIX socket
                                                                                                    [info] => 
                                                                                                    [insert_id] => 0
                                                                                                    [server_info] => 5.5.48-cll
                                                                                                    [server_version] => 50548
                                                                                                    [stat] => Uptime: 1034767  Threads: 3  Questions: 7593087  Slow queries: 0  Opens: 29461  Flush tables: 1  Open tables: 379  Queries per second avg: 7.337
                                                                                                    [sqlstate] => 00000
                                                                                                    [protocol_version] => 10
                                                                                                    [thread_id] => 102686
                                                                                                    [warning_count] => 0
                                                                                                )

                                                                                            [nameQuote:protected] => `
                                                                                            [nullDate:protected] => 0000-00-00 00:00:00
                                                                                            [_database:JDatabaseDriver:private] => liberuy2_vxbvn
                                                                                            [count:protected] => 141
                                                                                            [cursor:protected] => 
                                                                                            [debug:protected] => 
                                                                                            [limit:protected] => 0
                                                                                            [log:protected] => Array
                                                                                                (
                                                                                                )

                                                                                            [timings:protected] => Array
                                                                                                (
                                                                                                )

                                                                                            [callStacks:protected] => Array
                                                                                                (
                                                                                                )

                                                                                            [offset:protected] => 0
                                                                                            [options:protected] => Array
                                                                                                (
                                                                                                    [driver] => mysqli
                                                                                                    [host] => localhost
                                                                                                    [user] => liberuy2_lsm
                                                                                                    [password] => Lib3rtyB3ll
                                                                                                    [database] => liberuy2_vxbvn
                                                                                                    [prefix] => vxbvn_
                                                                                                    [select] => 1
                                                                                                    [port] => 3306
                                                                                                    [socket] => 
                                                                                                )

                                                                                            [sql:protected] => JDatabaseQueryMysqli Object
                                                                                                (
                                                                                                    [offset:protected] => 0
                                                                                                    [limit:protected] => 0
                                                                                                    [db:protected] => JDatabaseDriverMysqli Object
 *RECURSION*
                                                                                                    [sql:protected] => 
                                                                                                    [type:protected] => select
                                                                                                    [element:protected] => 
                                                                                                    [select:protected] => JDatabaseQueryElement Object
                                                                                                        (
                                                                                                            [name:protected] => SELECT
                                                                                                            [elements:protected] => Array
                                                                                                                (
                                                                                                                    [0] => id
                                                                                                                )

                                                                                                            [glue:protected] => ,
                                                                                                        )

                                                                                                    [delete:protected] => 
                                                                                                    [update:protected] => 
                                                                                                    [insert:protected] => 
                                                                                                    [from:protected] => JDatabaseQueryElement Object
                                                                                                        (
                                                                                                            [name:protected] => FROM
                                                                                                            [elements:protected] => Array
                                                                                                                (
                                                                                                                    [0] => #__menu
                                                                                                                )

                                                                                                            [glue:protected] => ,
                                                                                                        )

                                                                                                    [join:protected] => 
                                                                                                    [set:protected] => 
                                                                                                    [where:protected] => JDatabaseQueryElement Object
                                                                                                        (
                                                                                                            [name:protected] => WHERE
                                                                                                            [elements:protected] => Array
                                                                                                                (
                                                                                                                    [0] => lft BETWEEN 443 AND 444
                                                                                                                )

                                                                                                            [glue:protected] =>  AND 
                                                                                                        )

                                                                                                    [group:protected] => 
                                                                                                    [having:protected] => 
                                                                                                    [columns:protected] => 
                                                                                                    [values:protected] => 
                                                                                                    [order:protected] => 
                                                                                                    [autoIncrementField:protected] => 
                                                                                                    [call:protected] => 
                                                                                                    [exec:protected] => 
                                                                                                    [union:protected] => 
                                                                                                    [unionAll:protected] => 
                                                                                                )

                                                                                            [tablePrefix:protected] => vxbvn_
                                                                                            [utf:protected] => 1
                                                                                            [utf8mb4:protected] => 1
                                                                                            [errorNum:protected] => 0
                                                                                            [errorMsg:protected] => 
                                                                                            [transactionDepth:protected] => 0
                                                                                            [disconnectHandlers:protected] => Array
                                                                                                (
                                                                                                )

                                                                                        )

                                                                                    [_trackAssets:protected] => 
                                                                                    [_rules:protected] => 
                                                                                    [_locked:protected] => 
                                                                                    [_autoincrement:protected] => 1
                                                                                    [_observers:protected] => JObserverUpdater Object
                                                                                        (
                                                                                            [observers:protected] => Array
                                                                                                (
                                                                                                )

                                                                                            [doCallObservers:protected] => 1
                                                                                        )

                                                                                    [_columnAlias:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [_jsonEncode:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [_errors:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [extension_id] => 
                                                                                    [name] => 
                                                                                    [type] => 
                                                                                    [element] => 
                                                                                    [folder] => 
                                                                                    [client_id] => 
                                                                                    [enabled] => 
                                                                                    [access] => 1
                                                                                    [protected] => 
                                                                                    [manifest_cache] => 
                                                                                    [params] => 
                                                                                    [custom_data] => 
                                                                                    [system_data] => 
                                                                                    [checked_out] => 
                                                                                    [checked_out_time] => 
                                                                                    [ordering] => 
                                                                                    [state] => 
                                                                                )

                                                                            [extensionMessage:protected] => 
                                                                            [manifest] => SimpleXMLElement Object
                                                                                (
                                                                                    [@attributes] => Array
                                                                                        (
                                                                                            [method] => upgrade
                                                                                            [type] => component
                                                                                            [version] => 2.5.0
                                                                                        )

                                                                                    [name] => CjBlog
                                                                                    [creationDate] => 2015-May-30
                                                                                    [author] => Maverick
                                                                                    [authorEmail] => support@corejoomla.com
                                                                                    [authorUrl] => http://www.corejoomla.org
                                                                                    [copyright] => Copyright corejoomla.com. All rights reserved.
                                                                                    [license] => http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
                                                                                    [version] => 1.4.2
                                                                                    [description] => CjBlog - Simple yet powerful blogging platform for Joomla!
                                                                                    [install] => SimpleXMLElement Object
                                                                                        (
                                                                                            [sql] => SimpleXMLElement Object
                                                                                                (
                                                                                                    [file] => sql/install.mysql.utf8.sql
                                                                                                )

                                                                                        )

                                                                                    [files] => SimpleXMLElement Object
                                                                                        (
                                                                                            [@attributes] => Array
                                                                                                (
                                                                                                    [folder] => site
                                                                                                )

                                                                                            [filename] => Array
                                                                                                (
                                                                                                    [0] => index.html
                                                                                                    [1] => cjblog.php
                                                                                                    [2] => controller.php
                                                                                                    [3] => router.php
                                                                                                    [4] => api.php
                                                                                                )

                                                                                            [folder] => Array
                                                                                                (
                                                                                                    [0] => controllers
                                                                                                    [1] => models
                                                                                                    [2] => views
                                                                                                    [3] => helpers
                                                                                                    [4] => layouts
                                                                                                )

                                                                                        )

                                                                                    [media] => SimpleXMLElement Object
                                                                                        (
                                                                                            [@attributes] => Array
                                                                                                (
                                                                                                    [destination] => com_cjblog
                                                                                                    [folder] => site/media
                                                                                                )

                                                                                            [filename] => index.html
                                                                                            [folder] => Array
                                                                                                (
                                                                                                    [0] => css
                                                                                                    [1] => images
                                                                                                    [2] => js
                                                                                                )

                                                                                        )

                                                                                    [languages] => SimpleXMLElement Object
                                                                                        (
                                                                                            [@attributes] => Array
                                                                                                (
                                                                                                    [folder] => site
                                                                                                )

                                                                                            [language] => language/en-GB/en-GB.com_cjblog.ini
                                                                                        )

                                                                                    [administration] => SimpleXMLElement Object
                                                                                        (
                                                                                            [menu] => COM_CJBLOG
                                                                                            [submenu] => SimpleXMLElement Object
                                                                                                (
                                                                                                    [menu] => Array
                                                                                                        (
                                                                                                            [0] => COM_CJBLOG_CONTROL_PANEL
                                                                                                            [1] => COM_CJBLOG_BADGES
                                                                                                            [2] => COM_CJBLOG_BADGE_RULES
                                                                                                            [3] => COM_CJBLOG_BADGE_ACTIVITY
                                                                                                            [4] => COM_CJBLOG_POINTS
                                                                                                            [5] => COM_CJBLOG_POINT_RULES
                                                                                                            [6] => COM_CJBLOG_USERS
                                                                                                        )

                                                                                                )

                                                                                            [files] => SimpleXMLElement Object
                                                                                                (
                                                                                                    [@attributes] => Array
                                                                                                        (
                                                                                                            [folder] => admin
                                                                                                        )

                                                                                                    [filename] => Array
                                                                                                        (
                                                                                                            [0] => index.html
                                                                                                            [1] => access.xml
                                                                                                            [2] => config.xml
                                                                                                            [3] => cjblog.php
                                                                                                        )

                                                                                                    [folder] => Array
                                                                                                        (
                                                                                                            [0] => assets
                                                                                                            [1] => controllers
                                                                                                            [2] => helpers
                                                                                                            [3] => models
                                                                                                            [4] => sql
                                                                                                            [5] => views
                                                                                                        )

                                                                                                )

                                                                                            [languages] => SimpleXMLElement Object
                                                                                                (
                                                                                                    [@attributes] => Array
                                                                                                        (
                                                                                                            [folder] => admin
                                                                                                        )

                                                                                                    [language] => Array
                                                                                                        (
                                                                                                            [0] => language/en-GB/en-GB.com_cjblog.ini
                                                                                                            [1] => language/en-GB/en-GB.com_cjblog.sys.ini
                                                                                                        )

                                                                                                )

                                                                                        )

                                                                                    [scriptfile] => script.php
                                                                                    [updateservers] => SimpleXMLElement Object
                                                                                        (
                                                                                            [server] => http://www.corejoomla.com/media/autoupdates/com_cjblog.xml
                                                                                        )

                                                                                )

                                                                            [manifest_script:protected] => 
                                                                            [name:protected] => 
                                                                            [route:protected] => install
                                                                            [supportsDiscoverInstall:protected] => 1
                                                                            [type:protected] => module
                                                                            [parent:protected] => JInstaller Object
 *RECURSION*
                                                                            [db:protected] => JDatabaseDriverMysqli Object
                                                                                (
                                                                                    [name] => mysqli
                                                                                    [serverType] => mysql
                                                                                    [connection:protected] => mysqli Object
                                                                                        (
                                                                                            [affected_rows] => -1
                                                                                            [client_info] => 5.5.36
                                                                                            [client_version] => 50536
                                                                                            [connect_errno] => 0
                                                                                            [connect_error] => 
                                                                                            [errno] => 0
                                                                                            [error] => 
                                                                                            [error_list] => Array
                                                                                                (
                                                                                                )

                                                                                            [field_count] => 1
                                                                                            [host_info] => Localhost via UNIX socket
                                                                                            [info] => 
                                                                                            [insert_id] => 0
                                                                                            [server_info] => 5.5.48-cll
                                                                                            [server_version] => 50548
                                                                                            [stat] => Uptime: 1034767  Threads: 3  Questions: 7593088  Slow queries: 0  Opens: 29461  Flush tables: 1  Open tables: 379  Queries per second avg: 7.337
                                                                                            [sqlstate] => 00000
                                                                                            [protocol_version] => 10
                                                                                            [thread_id] => 102686
                                                                                            [warning_count] => 0
                                                                                        )

                                                                                    [nameQuote:protected] => `
                                                                                    [nullDate:protected] => 0000-00-00 00:00:00
                                                                                    [_database:JDatabaseDriver:private] => liberuy2_vxbvn
                                                                                    [count:protected] => 141
                                                                                    [cursor:protected] => 
                                                                                    [debug:protected] => 
                                                                                    [limit:protected] => 0
                                                                                    [log:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [timings:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [callStacks:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [offset:protected] => 0
                                                                                    [options:protected] => Array
                                                                                        (
                                                                                            [driver] => mysqli
                                                                                            [host] => localhost
                                                                                            [user] => liberuy2_lsm
                                                                                            [password] => Lib3rtyB3ll
                                                                                            [database] => liberuy2_vxbvn
                                                                                            [prefix] => vxbvn_
                                                                                            [select] => 1
                                                                                            [port] => 3306
                                                                                            [socket] => 
                                                                                        )

                                                                                    [sql:protected] => JDatabaseQueryMysqli Object
                                                                                        (
                                                                                            [offset:protected] => 0
                                                                                            [limit:protected] => 0
                                                                                            [db:protected] => JDatabaseDriverMysqli Object
 *RECURSION*
                                                                                            [sql:protected] => 
                                                                                            [type:protected] => select
                                                                                            [element:protected] => 
                                                                                            [select:protected] => JDatabaseQueryElement Object
                                                                                                (
                                                                                                    [name:protected] => SELECT
                                                                                                    [elements:protected] => Array
                                                                                                        (
                                                                                                            [0] => id
                                                                                                        )

                                                                                                    [glue:protected] => ,
                                                                                                )

                                                                                            [delete:protected] => 
                                                                                            [update:protected] => 
                                                                                            [insert:protected] => 
                                                                                            [from:protected] => JDatabaseQueryElement Object
                                                                                                (
                                                                                                    [name:protected] => FROM
                                                                                                    [elements:protected] => Array
                                                                                                        (
                                                                                                            [0] => #__menu
                                                                                                        )

                                                                                                    [glue:protected] => ,
                                                                                                )

                                                                                            [join:protected] => 
                                                                                            [set:protected] => 
                                                                                            [where:protected] => JDatabaseQueryElement Object
                                                                                                (
                                                                                                    [name:protected] => WHERE
                                                                                                    [elements:protected] => Array
                                                                                                        (
                                                                                                            [0] => lft BETWEEN 443 AND 444
                                                                                                        )

                                                                                                    [glue:protected] =>  AND 
                                                                                                )

                                                                                            [group:protected] => 
                                                                                            [having:protected] => 
                                                                                            [columns:protected] => 
                                                                                            [values:protected] => 
                                                                                            [order:protected] => 
                                                                                            [autoIncrementField:protected] => 
                                                                                            [call:protected] => 
                                                                                            [exec:protected] => 
                                                                                            [union:protected] => 
                                                                                            [unionAll:protected] => 
                                                                                        )

                                                                                    [tablePrefix:protected] => vxbvn_
                                                                                    [utf:protected] => 1
                                                                                    [utf8mb4:protected] => 1
                                                                                    [errorNum:protected] => 0
                                                                                    [errorMsg:protected] => 
                                                                                    [transactionDepth:protected] => 0
                                                                                    [disconnectHandlers:protected] => Array
                                                                                        (
                                                                                        )

                                                                                )

                                                                            [_errors:protected] => Array
                                                                                (
                                                                                )

                                                                        )

                                                                    [language] => JInstallerAdapterLanguage Object
                                                                        (
                                                                            [core:protected] => 
                                                                            [currentExtensionId:protected] => 
                                                                            [element:protected] => 
                                                                            [extension:protected] => JTableExtension Object
                                                                                (
                                                                                    [_tbl:protected] => #__extensions
                                                                                    [_tbl_key:protected] => extension_id
                                                                                    [_tbl_keys:protected] => Array
                                                                                        (
                                                                                            [0] => extension_id
                                                                                        )

                                                                                    [_db:protected] => JDatabaseDriverMysqli Object
                                                                                        (
                                                                                            [name] => mysqli
                                                                                            [serverType] => mysql
                                                                                            [connection:protected] => mysqli Object
                                                                                                (
                                                                                                    [affected_rows] => -1
                                                                                                    [client_info] => 5.5.36
                                                                                                    [client_version] => 50536
                                                                                                    [connect_errno] => 0
                                                                                                    [connect_error] => 
                                                                                                    [errno] => 0
                                                                                                    [error] => 
                                                                                                    [error_list] => Array
                                                                                                        (
                                                                                                        )

                                                                                                    [field_count] => 1
                                                                                                    [host_info] => Localhost via UNIX socket
                                                                                                    [info] => 
                                                                                                    [insert_id] => 0
                                                                                                    [server_info] => 5.5.48-cll
                                                                                                    [server_version] => 50548
                                                                                                    [stat] => Uptime: 1034767  Threads: 3  Questions: 7593089  Slow queries: 0  Opens: 29461  Flush tables: 1  Open tables: 379  Queries per second avg: 7.337
                                                                                                    [sqlstate] => 00000
                                                                                                    [protocol_version] => 10
                                                                                                    [thread_id] => 102686
                                                                                                    [warning_count] => 0
                                                                                                )

                                                                                            [nameQuote:protected] => `
                                                                                            [nullDate:protected] => 0000-00-00 00:00:00
                                                                                            [_database:JDatabaseDriver:private] => liberuy2_vxbvn
                                                                                            [count:protected] => 141
                                                                                            [cursor:protected] => 
                                                                                            [debug:protected] => 
                                                                                            [limit:protected] => 0
                                                                                            [log:protected] => Array
                                                                                                (
                                                                                                )

                                                                                            [timings:protected] => Array
                                                                                                (
                                                                                                )

                                                                                            [callStacks:protected] => Array
                                                                                                (
                                                                                                )

                                                                                            [offset:protected] => 0
                                                                                            [options:protected] => Array
                                                                                                (
                                                                                                    [driver] => mysqli
                                                                                                    [host] => localhost
                                                                                                    [user] => liberuy2_lsm
                                                                                                    [password] => Lib3rtyB3ll
                                                                                                    [database] => liberuy2_vxbvn
                                                                                                    [prefix] => vxbvn_
                                                                                                    [select] => 1
                                                                                                    [port] => 3306
                                                                                                    [socket] => 
                                                                                                )

                                                                                            [sql:protected] => JDatabaseQueryMysqli Object
                                                                                                (
                                                                                                    [offset:protected] => 0
                                                                                                    [limit:protected] => 0
                                                                                                    [db:protected] => JDatabaseDriverMysqli Object
 *RECURSION*
                                                                                                    [sql:protected] => 
                                                                                                    [type:protected] => select
                                                                                                    [element:protected] => 
                                                                                                    [select:protected] => JDatabaseQueryElement Object
                                                                                                        (
                                                                                                            [name:protected] => SELECT
                                                                                                            [elements:protected] => Array
                                                                                                                (
                                                                                                                    [0] => id
                                                                                                                )

                                                                                                            [glue:protected] => ,
                                                                                                        )

                                                                                                    [delete:protected] => 
                                                                                                    [update:protected] => 
                                                                                                    [insert:protected] => 
                                                                                                    [from:protected] => JDatabaseQueryElement Object
                                                                                                        (
                                                                                                            [name:protected] => FROM
                                                                                                            [elements:protected] => Array
                                                                                                                (
                                                                                                                    [0] => #__menu
                                                                                                                )

                                                                                                            [glue:protected] => ,
                                                                                                        )

                                                                                                    [join:protected] => 
                                                                                                    [set:protected] => 
                                                                                                    [where:protected] => JDatabaseQueryElement Object
                                                                                                        (
                                                                                                            [name:protected] => WHERE
                                                                                                            [elements:protected] => Array
                                                                                                                (
                                                                                                                    [0] => lft BETWEEN 443 AND 444
                                                                                                                )

                                                                                                            [glue:protected] =>  AND 
                                                                                                        )

                                                                                                    [group:protected] => 
                                                                                                    [having:protected] => 
                                                                                                    [columns:protected] => 
                                                                                                    [values:protected] => 
                                                                                                    [order:protected] => 
                                                                                                    [autoIncrementField:protected] => 
                                                                                                    [call:protected] => 
                                                                                                    [exec:protected] => 
                                                                                                    [union:protected] => 
                                                                                                    [unionAll:protected] => 
                                                                                                )

                                                                                            [tablePrefix:protected] => vxbvn_
                                                                                            [utf:protected] => 1
                                                                                            [utf8mb4:protected] => 1
                                                                                            [errorNum:protected] => 0
                                                                                            [errorMsg:protected] => 
                                                                                            [transactionDepth:protected] => 0
                                                                                            [disconnectHandlers:protected] => Array
                                                                                                (
                                                                                                )

                                                                                        )

                                                                                    [_trackAssets:protected] => 
                                                                                    [_rules:protected] => 
                                                                                    [_locked:protected] => 
                                                                                    [_autoincrement:protected] => 1
                                                                                    [_observers:protected] => JObserverUpdater Object
                                                                                        (
                                                                                            [observers:protected] => Array
                                                                                                (
                                                                                                )

                                                                                            [doCallObservers:protected] => 1
                                                                                        )

                                                                                    [_columnAlias:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [_jsonEncode:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [_errors:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [extension_id] => 
                                                                                    [name] => 
                                                                                    [type] => 
                                                                                    [element] => 
                                                                                    [folder] => 
                                                                                    [client_id] => 
                                                                                    [enabled] => 
                                                                                    [access] => 1
                                                                                    [protected] => 
                                                                                    [manifest_cache] => 
                                                                                    [params] => 
                                                                                    [custom_data] => 
                                                                                    [system_data] => 
                                                                                    [checked_out] => 
                                                                                    [checked_out_time] => 
                                                                                    [ordering] => 
                                                                                    [state] => 
                                                                                )

                                                                            [extensionMessage:protected] => 
                                                                            [manifest] => SimpleXMLElement Object
                                                                                (
                                                                                    [@attributes] => Array
                                                                                        (
                                                                                            [method] => upgrade
                                                                                            [type] => component
                                                                                            [version] => 2.5.0
                                                                                        )

                                                                                    [name] => CjBlog
                                                                                    [creationDate] => 2015-May-30
                                                                                    [author] => Maverick
                                                                                    [authorEmail] => support@corejoomla.com
                                                                                    [authorUrl] => http://www.corejoomla.org
                                                                                    [copyright] => Copyright corejoomla.com. All rights reserved.
                                                                                    [license] => http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
                                                                                    [version] => 1.4.2
                                                                                    [description] => CjBlog - Simple yet powerful blogging platform for Joomla!
                                                                                    [install] => SimpleXMLElement Object
                                                                                        (
                                                                                            [sql] => SimpleXMLElement Object
                                                                                                (
                                                                                                    [file] => sql/install.mysql.utf8.sql
                                                                                                )

                                                                                        )

                                                                                    [files] => SimpleXMLElement Object
                                                                                        (
                                                                                            [@attributes] => Array
                                                                                                (
                                                                                                    [folder] => site
                                                                                                )

                                                                                            [filename] => Array
                                                                                                (
                                                                                                    [0] => index.html
                                                                                                    [1] => cjblog.php
                                                                                                    [2] => controller.php
                                                                                                    [3] => router.php
                                                                                                    [4] => api.php
                                                                                                )

                                                                                            [folder] => Array
                                                                                                (
                                                                                                    [0] => controllers
                                                                                                    [1] => models
                                                                                                    [2] => views
                                                                                                    [3] => helpers
                                                                                                    [4] => layouts
                                                                                                )

                                                                                        )

                                                                                    [media] => SimpleXMLElement Object
                                                                                        (
                                                                                            [@attributes] => Array
                                                                                                (
                                                                                                    [destination] => com_cjblog
                                                                                                    [folder] => site/media
                                                                                                )

                                                                                            [filename] => index.html
                                                                                            [folder] => Array
                                                                                                (
                                                                                                    [0] => css
                                                                                                    [1] => images
                                                                                                    [2] => js
                                                                                                )

                                                                                        )

                                                                                    [languages] => SimpleXMLElement Object
                                                                                        (
                                                                                            [@attributes] => Array
                                                                                                (
                                                                                                    [folder] => site
                                                                                                )

                                                                                            [language] => language/en-GB/en-GB.com_cjblog.ini
                                                                                        )

                                                                                    [administration] => SimpleXMLElement Object
                                                                                        (
                                                                                            [menu] => COM_CJBLOG
                                                                                            [submenu] => SimpleXMLElement Object
                                                                                                (
                                                                                                    [menu] => Array
                                                                                                        (
                                                                                                            [0] => COM_CJBLOG_CONTROL_PANEL
                                                                                                            [1] => COM_CJBLOG_BADGES
                                                                                                            [2] => COM_CJBLOG_BADGE_RULES
                                                                                                            [3] => COM_CJBLOG_BADGE_ACTIVITY
                                                                                                            [4] => COM_CJBLOG_POINTS
                                                                                                            [5] => COM_CJBLOG_POINT_RULES
                                                                                                            [6] => COM_CJBLOG_USERS
                                                                                                        )

                                                                                                )

                                                                                            [files] => SimpleXMLElement Object
                                                                                                (
                                                                                                    [@attributes] => Array
                                                                                                        (
                                                                                                            [folder] => admin
                                                                                                        )

                                                                                                    [filename] => Array
                                                                                                        (
                                                                                                            [0] => index.html
                                                                                                            [1] => access.xml
                                                                                                            [2] => config.xml
                                                                                                            [3] => cjblog.php
                                                                                                        )

                                                                                                    [folder] => Array
                                                                                                        (
                                                                                                            [0] => assets
                                                                                                            [1] => controllers
                                                                                                            [2] => helpers
                                                                                                            [3] => models
                                                                                                            [4] => sql
                                                                                                            [5] => views
                                                                                                        )

                                                                                                )

                                                                                            [languages] => SimpleXMLElement Object
                                                                                                (
                                                                                                    [@attributes] => Array
                                                                                                        (
                                                                                                            [folder] => admin
                                                                                                        )

                                                                                                    [language] => Array
                                                                                                        (
                                                                                                            [0] => language/en-GB/en-GB.com_cjblog.ini
                                                                                                            [1] => language/en-GB/en-GB.com_cjblog.sys.ini
                                                                                                        )

                                                                                                )

                                                                                        )

                                                                                    [scriptfile] => script.php
                                                                                    [updateservers] => SimpleXMLElement Object
                                                                                        (
                                                                                            [server] => http://www.corejoomla.com/media/autoupdates/com_cjblog.xml
                                                                                        )

                                                                                )

                                                                            [manifest_script:protected] => 
                                                                            [name:protected] => 
                                                                            [route:protected] => install
                                                                            [supportsDiscoverInstall:protected] => 1
                                                                            [type:protected] => language
                                                                            [parent:protected] => JInstaller Object
 *RECURSION*
                                                                            [db:protected] => JDatabaseDriverMysqli Object
                                                                                (
                                                                                    [name] => mysqli
                                                                                    [serverType] => mysql
                                                                                    [connection:protected] => mysqli Object
                                                                                        (
                                                                                            [affected_rows] => -1
                                                                                            [client_info] => 5.5.36
                                                                                            [client_version] => 50536
                                                                                            [connect_errno] => 0
                                                                                            [connect_error] => 
                                                                                            [errno] => 0
                                                                                            [error] => 
                                                                                            [error_list] => Array
                                                                                                (
                                                                                                )

                                                                                            [field_count] => 1
                                                                                            [host_info] => Localhost via UNIX socket
                                                                                            [info] => 
                                                                                            [insert_id] => 0
                                                                                            [server_info] => 5.5.48-cll
                                                                                            [server_version] => 50548
                                                                                            [stat] => Uptime: 1034767  Threads: 3  Questions: 7593090  Slow queries: 0  Opens: 29461  Flush tables: 1  Open tables: 379  Queries per second avg: 7.337
                                                                                            [sqlstate] => 00000
                                                                                            [protocol_version] => 10
                                                                                            [thread_id] => 102686
                                                                                            [warning_count] => 0
                                                                                        )

                                                                                    [nameQuote:protected] => `
                                                                                    [nullDate:protected] => 0000-00-00 00:00:00
                                                                                    [_database:JDatabaseDriver:private] => liberuy2_vxbvn
                                                                                    [count:protected] => 141
                                                                                    [cursor:protected] => 
                                                                                    [debug:protected] => 
                                                                                    [limit:protected] => 0
                                                                                    [log:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [timings:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [callStacks:protected] => Array
                                                                                        (
                                                                                        )

                                                                                    [offset:protected] => 0
                                                                                    [options:protected] => Array
                                                                                        (
                                                                                            [driver] => mysqli
                                                                                            [host] => localhost
                                                                                            [user] => liberuy2_lsm
                                                                                            [password] => Lib3rtyB3ll
                                                                                            [database] => liberuy2_vxbvn
                                                                                            [prefix] => vxbvn_
                                                                                            [select] => 1
                                                                                            [port] => 3306
                                                                                            [socket] => 
                                                                                        )

                                                                                    [sql:protected] => JDatabaseQueryMysqli Object
                                                                                        (
                                                                                            [offset:protected] => 0
                                                                                            [limit:protected] => 0
                                                                                            [db:protected] => JDatabaseDriverMysqli Object
 *RECURSION*
                                                                                            [sql:protected] => 
                                                                                            [type:protected] => select
                                                                                            [element:protected] => 
                                                                                            [select:protected] => JDatabaseQueryElement Object
                                                                                                (
                                                                                                    [name:protected] => SELECT
                                                                                                    [elements:protected] => Array
                                                                                                        (
                                                                                                            [0] => id
                                                                                                        )

                                                                                                    [glue:protected] => ,
                                                                                                )

                                                                                            [delete:protected] => 
                                                                                            [update:protected] => 
                                                                                            [insert:protected] => 
                                                                                            [from:protected] => JDatabaseQueryElement Object
                                                                                                (
                                                                                                    [name:protected] => FROM
                                                                                                    [elements:protected] => Array
                                                                                                        (
                                                                                                            [0] => #__menu
                                                                                                        )

                                                                                                    [glue:protected] => ,
                                                                                                )

                                                                                            [join:protected] => 
                                                                                            [set:protected] => 
                                                                                            [where:protected] => JDatabaseQueryElement Object
                                                                                                (
                                                                                                    [name:protected] => WHERE
                                                                                                    [elements:protected] => Array
                                                                                                        (
                                                                                                            [0] => lft BETWEEN 443 AND 444
                                                                                                        )

                                                                                                    [glue:protected] =>  AND 
                                                                                                )

                                                                                            [group:protected] => 
                                                                                            [having:protected] => 
                                                                                            [columns:protected] => 
                                                                                            [values:protected] => 
                                                                                            [order:protected] => 
                                                                                            [autoIncrementField:protected] => 
                                                                                            [call:protected] => 
                                                                                            [exec:protected] => 
                                                                                            [union:protected] => 
                                                                                            [unionAll:protected] => 
                                                                                        )

                                                                                    [tablePrefix:protected] => vxbvn_
                                                                                    [utf:protected] => 1
                                                                                    [utf8mb4:protected] => 1
                                                                                    [errorNum:protected] => 0
                                                                                    [errorMsg:protected] => 
                                                                                    [transactionDepth:protected] => 0
                                                                                    [disconnectHandlers:protected] => Array
                                                                                        (
                                                                                        )

                                                                                )

                                                                            [_errors:protected] => Array
                                                                                (
                                                                                )

                                                                        )

                                                                )

                                                            [_adapterfolder:protected] => adapter
                                                            [_classprefix:protected] => JInstallerAdapter
                                                            [_basepath:protected] => /home/liberuy2/public_html/libraries/cms/installer
                                                            [_db:protected] => JDatabaseDriverMysqli Object
                                                                (
                                                                    [name] => mysqli
                                                                    [serverType] => mysql
                                                                    [connection:protected] => mysqli Object
                                                                        (
                                                                            [affected_rows] => -1
                                                                            [client_info] => 5.5.36
                                                                            [client_version] => 50536
                                                                            [connect_errno] => 0
                                                                            [connect_error] => 
                                                                            [errno] => 0
                                                                            [error] => 
                                                                            [error_list] => Array
                                                                                (
                                                                                )

                                                                            [field_count] => 1
                                                                            [host_info] => Localhost via UNIX socket
                                                                            [info] => 
                                                                            [insert_id] => 0
                                                                            [server_info] => 5.5.48-cll
                                                                            [server_version] => 50548
                                                                            [stat] => Uptime: 1034767  Threads: 3  Questions: 7593091  Slow queries: 0  Opens: 29461  Flush tables: 1  Open tables: 379  Queries per second avg: 7.337
                                                                            [sqlstate] => 00000
                                                                            [protocol_version] => 10
                                                                            [thread_id] => 102686
                                                                            [warning_count] => 0
                                                                        )

                                                                    [nameQuote:protected] => `
                                                                    [nullDate:protected] => 0000-00-00 00:00:00
                                                                    [_database:JDatabaseDriver:private] => liberuy2_vxbvn
                                                                    [count:protected] => 141
                                                                    [cursor:protected] => 
                                                                    [debug:protected] => 
                                                                    [limit:protected] => 0
                                                                    [log:protected] => Array
                                                                        (
                                                                        )

                                                                    [timings:protected] => Array
                                                                        (
                                                                        )

                                                                    [callStacks:protected] => Array
                                                                        (
                                                                        )

                                                                    [offset:protected] => 0
                                                                    [options:protected] => Array
                                                                        (
                                                                            [driver] => mysqli
                                                                            [host] => localhost
                                                                            [user] => liberuy2_lsm
                                                                            [password] => Lib3rtyB3ll
                                                                            [database] => liberuy2_vxbvn
                                                                            [prefix] => vxbvn_
                                                                            [select] => 1
                                                                            [port] => 3306
                                                                            [socket] => 
                                                                        )

                                                                    [sql:protected] => JDatabaseQueryMysqli Object
                                                                        (
                                                                            [offset:protected] => 0
                                                                            [limit:protected] => 0
                                                                            [db:protected] => JDatabaseDriverMysqli Object
 *RECURSION*
                                                                            [sql:protected] => 
                                                                            [type:protected] => select
                                                                            [element:protected] => 
                                                                            [select:protected] => JDatabaseQueryElement Object
                                                                                (
                                                                                    [name:protected] => SELECT
                                                                                    [elements:protected] => Array
                                                                                        (
                                                                                            [0] => id
                                                                                        )

                                                                                    [glue:protected] => ,
                                                                                )

                                                                            [delete:protected] => 
                                                                            [update:protected] => 
                                                                            [insert:protected] => 
                                                                            [from:protected] => JDatabaseQueryElement Object
                                                                                (
                                                                                    [name:protected] => FROM
                                                                                    [elements:protected] => Array
                                                                                        (
                                                                                            [0] => #__menu
                                                                                        )

                                                                                    [glue:protected] => ,
                                                                                )

                                                                            [join:protected] => 
                                                                            [set:protected] => 
                                                                            [where:protected] => JDatabaseQueryElement Object
                                                                                (
                                                                                    [name:protected] => WHERE
                                                                                    [elements:protected] => Array
                                                                                        (
                                                                                            [0] => lft BETWEEN 443 AND 444
                                                                                        )

                                                                                    [glue:protected] =>  AND 
                                                                                )

                                                                            [group:protected] => 
                                                                            [having:protected] => 
                                                                            [columns:protected] => 
                                                                            [values:protected] => 
                                                                            [order:protected] => 
                                                                            [autoIncrementField:protected] => 
                                                                            [call:protected] => 
                                                                            [exec:protected] => 
                                                                            [union:protected] => 
                                                                            [unionAll:protected] => 
                                                                        )

                                                                    [tablePrefix:protected] => vxbvn_
                                                                    [utf:protected] => 1
                                                                    [utf8mb4:protected] => 1
                                                                    [errorNum:protected] => 0
                                                                    [errorMsg:protected] => 
                                                                    [transactionDepth:protected] => 0
                                                                    [disconnectHandlers:protected] => Array
                                                                        (
                                                                        )

                                                                )

                                                            [_errors:protected] => Array
                                                                (
                                                                )

                                                        )

                                                    [db:protected] => JDatabaseDriverMysqli Object
                                                        (
                                                            [name] => mysqli
                                                            [serverType] => mysql
                                                            [connection:protected] => mysqli Object
                                                                (
                                                                    [affected_rows] => -1
                                                                    [client_info] => 5.5.36
                                                                    [client_version] => 50536
                                                                    [connect_errno] => 0
                                                                    [connect_error] => 
                                                                    [errno] => 0
                                                                    [error] => 
                                                                    [error_list] => Array
                                                                        (
                                                                        )

                                                                    [field_count] => 1
                                                                    [host_info] => Localhost via UNIX socket
                                                                    [info] => 
                                                                    [insert_id] => 0
                                                                    [server_info] => 5.5.48-cll
                                                                    [server_version] => 50548
                                                                    [stat] => Uptime: 1034767  Threads: 3  Questions: 7593092  Slow queries: 0  Opens: 29461  Flush tables: 1  Open tables: 379  Queries per second avg: 7.337
                                                                    [sqlstate] => 00000
                                                                    [protocol_version] => 10
                                                                    [thread_id] => 102686
                                                                    [warning_count] => 0
                                                                )

                                                            [nameQuote:protected] => `
                                                            [nullDate:protected] => 0000-00-00 00:00:00
                                                            [_database:JDatabaseDriver:private] => liberuy2_vxbvn
                                                            [count:protected] => 141
                                                            [cursor:protected] => 
                                                            [debug:protected] => 
                                                            [limit:protected] => 0
                                                            [log:protected] => Array
                                                                (
                                                                )

                                                            [timings:protected] => Array
                                                                (
                                                                )

                                                            [callStacks:protected] => Array
                                                                (
                                                                )

                                                            [offset:protected] => 0
                                                            [options:protected] => Array
                                                                (
                                                                    [driver] => mysqli
                                                                    [host] => localhost
                                                                    [user] => liberuy2_lsm
                                                                    [password] => Lib3rtyB3ll
                                                                    [database] => liberuy2_vxbvn
                                                                    [prefix] => vxbvn_
                                                                    [select] => 1
                                                                    [port] => 3306
                                                                    [socket] => 
                                                                )

                                                            [sql:protected] => JDatabaseQueryMysqli Object
                                                                (
                                                                    [offset:protected] => 0
                                                                    [limit:protected] => 0
                                                                    [db:protected] => JDatabaseDriverMysqli Object
 *RECURSION*
                                                                    [sql:protected] => 
                                                                    [type:protected] => select
                                                                    [element:protected] => 
                                                                    [select:protected] => JDatabaseQueryElement Object
                                                                        (
                                                                            [name:protected] => SELECT
                                                                            [elements:protected] => Array
                                                                                (
                                                                                    [0] => id
                                                                                )

                                                                            [glue:protected] => ,
                                                                        )

                                                                    [delete:protected] => 
                                                                    [update:protected] => 
                                                                    [insert:protected] => 
                                                                    [from:protected] => JDatabaseQueryElement Object
                                                                        (
                                                                            [name:protected] => FROM
                                                                            [elements:protected] => Array
                                                                                (
                                                                                    [0] => #__menu
                                                                                )

                                                                            [glue:protected] => ,
                                                                        )

                                                                    [join:protected] => 
                                                                    [set:protected] => 
                                                                    [where:protected] => JDatabaseQueryElement Object
                                                                        (
                                                                            [name:protected] => WHERE
                                                                            [elements:protected] => Array
                                                                                (
                                                                                    [0] => lft BETWEEN 443 AND 444
                                                                                )

                                                                            [glue:protected] =>  AND 
                                                                        )

                                                                    [group:protected] => 
                                                                    [having:protected] => 
                                                                    [columns:protected] => 
                                                                    [values:protected] => 
                                                                    [order:protected] => 
                                                                    [autoIncrementField:protected] => 
                                                                    [call:protected] => 
                                                                    [exec:protected] => 
                                                                    [union:protected] => 
                                                                    [unionAll:protected] => 
                                                                )

                                                            [tablePrefix:protected] => vxbvn_
                                                            [utf:protected] => 1
                                                            [utf8mb4:protected] => 1
                                                            [errorNum:protected] => 0
                                                            [errorMsg:protected] => 
                                                            [transactionDepth:protected] => 0
                                                            [disconnectHandlers:protected] => Array
                                                                (
                                                                )

                                                        )

                                                    [_errors:protected] => Array
                                                        (
                                                        )

                                                )

                                        )

                                )

                            [6] => Array
                                (
                                    [file] => /home/liberuy2/public_html/libraries/cms/installer/adapter.php
                                    [line] => 769
                                    [function] => triggerManifestScript
                                    [class] => JInstallerAdapter
                                    [type] => ->
                                    [args] => Array
                                        (
                                            [0] => postflight
                                        )

                                )

                            [7] => Array
                                (
                                    [file] => /home/liberuy2/public_html/libraries/cms/installer/installer.php
                                    [line] => 469
                                    [function] => install
                                    [class] => JInstallerAdapter
                                    [type] => ->
                                    [args] => Array
                                        (
                                        )

                                )

                            [8] => Array
                                (
                                    [file] => /home/liberuy2/public_html/libraries/cms/installer/adapter/package.php
                                    [line] => 128
                                    [function] => install
                                    [class] => JInstaller
                                    [type] => ->
                                    [args] => Array
                                        (
                                            [0] => /home/liberuy2/public_html/LibertyBell/tmp/install_56fd3b2be1d5a/packages/install_56fd3b2bed9d0
                                        )

                                )

                            [9] => Array
                                (
                                    [file] => /home/liberuy2/public_html/libraries/cms/installer/adapter.php
                                    [line] => 692
                                    [function] => copyBaseFiles
                                    [class] => JInstallerAdapterPackage
                                    [type] => ->
                                    [args] => Array
                                        (
                                        )

                                )

                            [10] => Array
                                (
                                    [file] => /home/liberuy2/public_html/libraries/cms/installer/installer.php
                                    [line] => 469
                                    [function] => install
                                    [class] => JInstallerAdapter
                                    [type] => ->
                                    [args] => Array
                                        (
                                        )

                                )

                            [11] => Array
                                (
                                    [file] => /home/liberuy2/public_html/administrator/components/com_installer/models/install.php
                                    [line] => 158
                                    [function] => install
                                    [class] => JInstaller
                                    [type] => ->
                                    [args] => Array
                                        (
                                            [0] => /home/liberuy2/public_html/LibertyBell/tmp/install_56fd3b2be1d5a
                                        )

                                )

                            [12] => Array
                                (
                                    [file] => /home/liberuy2/public_html/administrator/components/com_installer/controllers/install.php
                                    [line] => 33
                                    [function] => install
                                    [class] => InstallerModelInstall
                                    [type] => ->
                                    [args] => Array
                                        (
                                        )

                                )

                            [13] => Array
                                (
                                    [file] => /home/liberuy2/public_html/libraries/legacy/controller/legacy.php
                                    [line] => 728
                                    [function] => install
                                    [class] => InstallerControllerInstall
                                    [type] => ->
                                    [args] => Array
                                        (
                                        )

                                )

                            [14] => Array
                                (
                                    [file] => /home/liberuy2/public_html/administrator/components/com_installer/installer.php
                                    [line] => 19
                                    [function] => execute
                                    [class] => JControllerLegacy
                                    [type] => ->
                                    [args] => Array
                                        (
                                            [0] => install
                                        )

                                )

                            [15] => Array
                                (
                                    [file] => /home/liberuy2/public_html/libraries/cms/component/helper.php
                                    [line] => 405
                                    [args] => Array
                                        (
                                            [0] => /home/liberuy2/public_html/administrator/components/com_installer/installer.php
                                        )

                                    [function] => require_once
                                )

                            [16] => Array
                                (
                                    [file] => /home/liberuy2/public_html/libraries/cms/component/helper.php
                                    [line] => 380
                                    [function] => executeComponent
                                    [class] => JComponentHelper
                                    [type] => ::
                                    [args] => Array
                                        (
                                            [0] => /home/liberuy2/public_html/administrator/components/com_installer/installer.php
                                        )

                                )

                            [17] => Array
                                (
                                    [file] => /home/liberuy2/public_html/libraries/cms/application/administrator.php
                                    [line] => 98
                                    [function] => renderComponent
                                    [class] => JComponentHelper
                                    [type] => ::
                                    [args] => Array
                                        (
                                            [0] => com_installer
                                        )

                                )

                            [18] => Array
                                (
                                    [file] => /home/liberuy2/public_html/libraries/cms/application/administrator.php
                                    [line] => 152
                                    [function] => dispatch
                                    [class] => JApplicationAdministrator
                                    [type] => ->
                                    [args] => Array
                                        (
                                        )

                                )

                            [19] => Array
                                (
                                    [file] => /home/liberuy2/public_html/libraries/cms/application/cms.php
                                    [line] => 257
                                    [function] => doExecute
                                    [class] => JApplicationAdministrator
                                    [type] => ->
                                    [args] => Array
                                        (
                                        )

                                )

                            [20] => Array
                                (
                                    [file] => /home/liberuy2/public_html/administrator/index.php
                                    [line] => 51
                                    [function] => execute
                                    [class] => JApplicationCms
                                    [type] => ->
                                    [args] => Array
                                        (
                                        )

                                )

                        )

                    [previous:Exception:private] => 
                )

        )

    [id] => 325
    [menutype] => cjblogmenu
    [title] => Categories
    [note] => 
    [path] => blog
    [link] => index.php?option=com_cjblog&view=categories
    [type] => component
    [published] => 1
    [component_id] => 10058
    [checked_out] => 0
    [checked_out_time] => 0000-00-00 00:00:00
    [browserNav] => 0
    [access] => 1
    [img] =>  
    [template_style_id] => 0
    [params] => {"menu-anchor_title":"","menu-anchor_css":"","menu_image":"","menu_text":1,"page_title":"","show_page_heading":0,"page_heading":"","pageclass_sfx":"","menu-meta_description":"","menu-meta_keywords":"","robots":"","secure":0}
    [home] => 0
    [language] => *
    [client_id] => 0
)

