<?php

/************ User Object *********/

/**
 * @api {user-object} {} User Object
 * @apiDescription User object attributes.
 * @apiName UserObject
 * @apiGroup Objects
 *
 * @apiParam {String{100}} password Password of the user.
 * @apiParam {String{30}} firstName First name.
 * @apiParam {String{30}} lastName Last name.
 * @apiParam {String{60}} email User Email. Either Email or sysEmail required.
 * @apiParam {String{60}} sysEmail Email address of the system user. Either Email or sysEmail required.
 * @apiParam {String{15}} [timeZone]  User timezone based on php timezone list.
 * @apiParam {String{15}} [roleName]  Role name of the user.
 * @apiParam {Number} type User type. 1 - System User, 2 - Normal User
 * @apiParam {Number} status Account status. 1 - Active, 0 - Inactive
 * @apiParam {String{20}} [phone] User phone number in international format.
 * @apiParam {String{20}} [createdAt] Record created date & time UTC. Ex:yyyy-mm-dd hh:mm:ss
 * @apiParam {String{20}} [updatedAt]  Record updated date & time UTC. Ex:yyyy-mm-dd hh:mm:ss
 * @apiParam {Number} [createdById]  User id of the record creater.
 * @apiParam {Number} [updatedById]  User id of the record updater.
 * @apiParam {String} [lastAccess]  Last access date & time UTC.
 * @apiParam {String{60}} [address] User address.
 * @apiParam {String{30}} [fbId] Facebook id.
 * @apiParam {Number} [gender] Gender. 1 - Male, 2 - Female
 * @apiParam {String{10}} [dob] Date of birth. Ex:yyyy-mm-dd
 * @apiParam {Number} [loginType] Login type. 1 - Email, 2 - Facebook
 * @apiParam {String} [userOwnDeviceTypes] Device types. 1 - Roku, 2 - Apple TV, 3 - Chromecast, 4 - Amazon Fire, 5 -
 * Xbox, 6 - PS, 7 - Smart TV
 */


/************ Authenticate Object *********/

/**
 * @api {authenticate-object} {} Authenticate Object
 * @apiDescription Authenticate object attributes.
 * @apiName AuthenticateObject
 * @apiGroup Objects
 *
 * @apiParam {String{60}} email User Email. Either Email or sysEmail required.
 * @apiParam {String{100}} password Password of the user.
 * @apiParam {Number} [loginType] Login type. 1 - Email, 2 - Facebook
 * @apiParam {Number} type User type. 1 - System user, 2 - Normal user
 */


/************ Permission Object *********/

/**
 * @api {permission-object} {} Permission Object
 * @apiDescription permission object attributes.
 * @apiName PermissionObject
 * @apiGroup Objects
 *
 * @apiParam {String{30}} name Permission Name.
 * @apiParam {String{60}} description Description of the permission.
 * @apiParam {string{30}} category Category of permission
 * @apiParam {String{20}} [createdAt] Record created date & time UTC. Ex:yyyy-mm-dd hh:mm:ss
 * @apiParam {String{20}} [updatedAt]  Record updated date & time UTC. Ex:yyyy-mm-dd hh:mm:ss
 * @apiParam {Number} [createdById]  User id of the record creater.
 * @apiParam {Number} [updatedById]  User id of the record updater.
 */

/************ Role Object *********/

/**
 * @api {role-object} {} Role Object
 * @apiDescription role object attributes.
 * @apiName RoleObject
 * @apiGroup Objects
 *
 * @apiParam {String{30}} name Role Name.
 * @apiParam {String{60}} description Description of the Role.
 * @apiParam {String{30}} roleName Role Name.
 * @apiParam {string{30}} permissionName Permission Name
 * @apiParam {String{20}} [createdAt] Record created date & time UTC. Ex:yyyy-mm-dd hh:mm:ss
 * @apiParam {String{20}} [updatedAt]  Record updated date & time UTC. Ex:yyyy-mm-dd hh:mm:ss
 * @apiParam {Number} [createdById]  User id of the record creater.
 * @apiParam {Number} [updatedById]  User id of the record updater.
 */


/************ Forgot Password Object *********/

/**
 * @api {forgot-password-object} {} Forgot Password Object
 * @apiDescription Forgot password.
 * @apiName ForgotPasswordObject
 * @apiGroup Objects
 *
 * @apiParam {String{64}} email User email.
 */

/************ Reset Password Object *********/

/**
 * @api {reset-password-object} {} Reset Password Object
 * @apiDescription Reset password.
 * @apiName ResetPasswordObject
 * @apiGroup Objects
 *
 * @apiParam {String} passwordResetToken Password reset token which comes with password change URL.
 * @apiParam {String} password New password.
 */

/********* VideoActivity Object **********/

/**
 * @api {VideoActivity-Object} {} VideoActivity Object
 * @apiDescription videoActivity object attributes.
 * @apiName VideoActivity
 * @apiGroup Objects
 *
 * @apiParam {String{50}} videoRefId Video Reference Id.
 * @apiParam {String{255}} deviceId Device Id.
 * @apiParam {Number} [status]  status.
 */
