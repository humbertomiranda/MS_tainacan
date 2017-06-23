<?php
include_once ('../../../../../wp-config.php');
include_once ('../../../../../wp-load.php');
include_once ('../../../../../wp-includes/wp-db.php');
include_once ('js/profile_js.php');

global $current_user;
get_currentuserinfo();

$current_user_metas = get_user_meta($current_user->ID);
?>

<input type="hidden" id="src_login" name="src" value="<?php echo get_template_directory_uri() ?>">
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >


            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $current_user->display_name; ?></h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3 col-lg-3 hoverzoom" align="center"> 
                            <img alt="User Pic" src="<?php echo get_template_directory_uri() ?>/libraries/images/profile-avatar.jpg" class="img-circle img-responsive"> 
                            <div class="retina">
                                <button type="button" class="btn btn-primary"><?php _e('Change','tainacan'); ?></button>
                            </div>
                        </div>

                        <div class=" col-md-9 col-lg-9 "> 
                            <table class="table table-user-information">
                                <tbody>
                                    <tr>
                                        <td><?php _e('Date of register','tainacan'); ?>:</td>
                                        <td><?php echo $current_user->user_registered; ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php _e('First Name','tainacan'); ?>:</td>
                                        <td><?php echo $current_user_metas['first_name'][0]; ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php _e('Last Name','tainacan'); ?>:</td>
                                        <td><?php echo $current_user_metas['last_name'][0]; ?></td>
                                    </tr>

                                    <tr>
                                        <td><?php _e('Username','tainacan'); ?>:</td>
                                        <td><?php echo $current_user->user_login; ?></td>
                                    </tr>

                                    <tr>
                                        <td><?php _e('Email','tainacan'); ?>:</td>
                                        <td><a href="mailto:<?php echo $current_user->user_email; ?>"><?php echo $current_user->user_email; ?></a></td>
                                    </tr>

                                </tbody>
                            </table>

                            <a id="open-modalEdit" class="btn btn-primary pull-right"><?php _e('Edit profile','tainacan'); ?></a>
                        </div>
                    </div>
                </div>
                <!--div class="panel-footer">
                    <a data-original-title="Broadcast Message" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i></a>
                    <span class="pull-right">
                        <!--a href="edit.html" data-original-title="Edit this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a-->
                        <!--a data-original-title="Remove this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a-->
                    <!--/span>
                </div-->

            </div>
        </div>
    </div>
</div>

<!-- Modal Edit profile -->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><?php _e('Edit profile!','tainacan'); ?></h4>
                </div>
                <div class="modal-body">
                    <div>
                        <h4><?php _e('Change names and email'); ?></h4>
                        <form id="formNames">
                            <input type="hidden" name="operation" value="change_names">
                            <input type="hidden" name="id" id="id" value="<?php echo $current_user->ID; ?>"> 
                            <div class="form-group">
                                <label for="new-first-name"><?php _e('First Name'); ?></span></label>
                                <input class="form-control" type="text" name="new-first-name" id="new-first-name" placeholder="<?php echo $current_user_metas['first_name'][0]; ?>" value="">
                            </div>
                            <div class="form-group">
                                <label for="new-last-name"><?php _e('Last Name'); ?></span></label>
                                <input class="form-control" type="text" name="new-last-name" id="new-last-name" placeholder="<?php echo $current_user_metas['last_name'][0]; ?>" value="">
                            </div>
                            <div class="form-group">
                                <label for="new-email"><?php _e('Email'); ?></label>
                                <input class="form-control" type="email" name="new-email" id="new-email" placeholder="<?php echo $current_user->user_email; ?>" value="">
                            </div>
                        </form>
                        <button type="submit" class="btn btn-primary" onclick="check_change_names(); return false;"><?php _e('Submit','tainacan'); ?></button>
                    </div>
                    <div>
                        <hr />
                        <h4><?php _e('Change password'); ?></h4>
                        <form  id="formUserChangePassword" name="formUserChangePassword" >
                            <input type="hidden" name="operation" value="change_password">
                            <input type="hidden" name="password_user_id" id="password_user_id" value="<?php echo $current_user->ID; ?>"/> 
                            <div class="form-group">
                                <label for="old_password"><?php _e('Old Password','tainacan'); ?><span style="color: #EE0000;"> *</span></label>
                                <input type="password" required="required" class="form-control" name="old_password" id="old_password" placeholder="<?php _e('Type here the old password','tainacan'); ?>">
                            </div>
                            <div class="form-group">
                                <label for="new_password"><?php _e('New Password','tainacan'); ?><span style="color: #EE0000;"> *</span></label>
                                <input type="password" required="required" class="form-control" name="new_password" id="new_password" placeholder="<?php _e('Type here the new password','tainacan'); ?>">
                            </div>
                            <div class="form-group">
                                <label for="new_check_password"><?php _e('Confirm new password','tainacan'); ?><span style="color: #EE0000;"> *</span></label>
                                <input type="password" required="required" class="form-control" name="new_check_password" id="new_check_password" placeholder="<?php _e('Type here your new password again','tainacan'); ?>">
                            </div>
                        </form> 
                        <button type="submit" class="btn btn-primary" onclick="check_change_passwords(); return false;"><?php _e('Submit','tainacan'); ?></button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close','tainacan'); ?></button>
                </div>
        </div>
    </div>
</div>