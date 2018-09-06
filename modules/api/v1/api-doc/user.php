<?php
/************ Create User *********/

/**
 * @api {post} http://<base-url>/api/v1/user Create User
 * @apiDescription Add new user to the system. Use this method for user registration or create system user.
 * - Refer "UserObject" for necessary parameters. Following example illustrates the valid parameters for user creates.
 * Rest of the parameters described in "UserObject" are used for viewing and some other requests.
 * - Response - "Common Response", possible response codes are SUCCESS, FAILED, MISSING_MANDATORY_FIELD,
 * EMAIL_EXISTS, VALIDATION_FAILED, INVALID_EMAIL, EXCEED_CHARACTER_LIMIT
 * - Mandatory fields are
 * firstName, lastName, type
 * email, password combination or fbId
 *
 * @apiName Create
 * @apiGroup User
 *
 * @apiExample Example Request:
 *    {
 *        "firstName": "Yohan",
 *        "lastName": "Piyadigamage",
 *        "password": "test.123",
 *        "gender": 1,
 *        "dob": "2001-03-03",
 *        "loginType": 1,
 *        "email": "yohan@gmail.com",
 *        "sysEmail": "yohan@gmail.com",
 *        "timeZone": "asia/colombo",
 *        "roleName": "Admin",
 *        "type": "1",
 *        "phone": "+9477395698",
 *        "address": "Torington Flats, Colombo 07",
 *        "userOwnDeviceTypes": "1,2"
 *    }
 */

/************ View User *********/

/**
 * @api {get} http://<base-url>/api/user/:id View User
 * @apiDescription Retrieve existing user information.
 * - Success response - "Common Response Object" Possible response codes are SUCCESS, RECORD_NOT_EXISTS , AUTH_FAILED .
 * - access-token required in header.
 *
 * @apiName View
 * @apiGroup User
 *
 * @apiParam {number} id User id.
 *
 * @apiExample Example Response:
 *
 *
 *    {
 *        "data": {
 *             "user": {
 *                 "id": 15,
 *                 "firstName": "Yohangggg",
 *                 "lastName": "Hirimuthugoda",
 *                 "username": "admin",
 *                 "email": "yohan@gmail.com",
 *                 "sysEmail": "nasmy@gmail.com",
 *                 "timeZone": "asia/colombo",
 *                 "roleName": "Admin",
 *                 "type": 1,
 *                 "status": 1,
 *                 "phone": "+9477395698",
 *                 "createdAt": "2017-08-30 00:00:00",
 *                 "updatedAt": "2017-09-03 05:59:22",
 *                 "createdById": null,
 *                 "updatedById": 15,
 *                 "lastAccess": "2017-09-03 05:59:22",
 *                 "address": "Torington Flats, Colombo 07",
 *                 "userOwnDeviceTypes":"1,2,3,5"
 *             }
 *         }
 *    }
 */

/************ Update User *********/

/**
 * @api {put} http://<base-url>/api/user/:id Update User
 * @apiDescription Update existing user details.
 * - Success response - "Common Response" Possible response codes are SUCCESS, FAILED, AUTH_FAILED, MISSING_MANDATORY_FIELD,
 * EMAIL_EXISTS, VALIDATION_FAILED, INVALID_EMAIL, EXCEED_CHARACTER_LIMIT
 * - access-token required in header.
 *
 * @apiName Update
 * @apiGroup User
 *
 * @apiParam {number} id User id.
 *
 * @apiExample Example Request:
 *
 *   {
 *       "firstName": "Yohangggg",
 *       "lastName": "Hirimuthugoda",
 *       "email": "yohan@gmail.com",
 *       "sysEmail": "nasmy@gmail.com",
 *       "timeZone": "asia/colombo",
 *       "type": "1",
 *       "phone": "+9477395698",
 *       "address": "Torington Flats, Colombo 07",
 *       "dob": "1988-03-10",
 *       "gender": "2"
 *   }
 */

/************ Authenticate User *********/

/**
 * @api {post} http://<base-url>/api/user/authenticate Authenticate User
 * @apiDescription Authenticate existing user.
 * - Success response - "Common Response" Possible response codes are SUCCESS, FAILED, AUTH_FAILED, MISSING_MANDATORY_ATTRIBUTE
 *
 * @apiName Authenticate
 * @apiGroup authenticate
 *
 * @apiParam {number} id User id.
 * @apiExample Example Request:
 *
 *    {
 *        "email": "yohan@gmail.com",
 *        "password": "test.123",
 *        "loginType": "1",
 *        "type":"2",
 *        "deviceInfo": {
 *             "uuId":"KR123TYH348DFdfg",
 *             "type":"ios",
 *             "token":"KR123TYH348DFdfg"
 *        }
 *    }
 */


/************ Delete Users *********/

/**
 * @api {delete} http://<base-url>/api/user/:id Delete Permission
 * @apiDescription Delete existing user details.
 * - Success response - "Common Response" Possible response codes are SUCCESS, FAILED, MISSING_MANDATORY_FIELD,
 * AUTH_FAILED, RECORD_NOT_EXISTS, EXCEED_CHARACTER_LIMIT, USER_IN_USE
 * - access-token required in header.
 *
 * @apiName Delete
 * @apiGroup User
 *
 * @apiParam {number} id User Id.
 *
 * @apiExample Example Response:
 *
 *    {
 *        "code": "SUCCESS",
 *        "message": null,
 *        "data": [],
 *        "attribute": null
 *    }
 */

/************ Search Users *********/

/**
 * @api {get} http://<base-url>/api/user-requests Get Users List
 * @apiDescription Search Users by various parameters.
 * Success response - "Common Response", possible status codes are MISSING_MANDATORY_FIELD,
 * - RECORD_NOT_EXIST, AUTH_FAILED, FAILED , VALIDATION_FAILD
 * - access-token is required in header.
 *
 * @apiName Search
 * @apiGroup User
 *
 * @apiParam {String} [firstName] firstName of the user.
 * @apiParam {String} [lastName] lastName of the user.
 * @apiParam {String} [userName] userName of the user.
 * @apiParam {String} [email] email of the user
 * @apiParam {String} [sysEmail] sysEmail of the user
 * @apiParam {String} [timeZone] firstName of the user.
 * @apiParam {String} [roleName] roleName of the user.
 * @apiParam {String} [type] type of the user.
 * @apiParam {String} [address] address of the user
 * @apiParam {String} [phone] phone of the user
 *
 * @apiSuccessExample Success-Response:
 *     {
 *         "code": "SUCCESS",
 *         "message": null,
 *         "data": {
 *                 "total": 1,
 *                 "permissions": [
 *                  {
 *                       "id": 15,
 *                       "firstName": "Yohangggg",
 *                       "lastName": "Hirimuthugoda",
 *                       "username": "admin",
 *                       "email": "yohan@gmail.com",
 *                       "sysEmail": "nasmy@gmail.com",
 *                       "timeZone": "asia/colombo",
 *                       "roleName": "Admin",
 *                       "type": 1,
 *                       "status": 1,
 *                       "phone": "+9477395698",
 *                       "createdAt": "2017-08-30 00:00:00",
 *                       "updatedAt": "2017-09-04 08:49:57",
 *                       "createdById": null,
 *                       "updatedById": 15,
 *                       "lastAccess": "2017-09-04 08:49:57",
 *                       "address": "Torington Flats, Colombo 07"
 *                 }
 *             ],
 *         },
 *     }
 */

/************ Forgot Password *********/

/**
 * @api {post} http://<base-url>/api/user/forgot-password Forgot password
 * @apiDescription Send an email to particular user along with password reset link.
 * Password reset link needs to be configured in BO. BO sends password reset link on the email as follows.
 * When user clicks, it callbacks with "q" parameter which contains the password reset token.
 * It needs to be sent to BO when making "Reset Password" API call.
 * - Ex:http://password/reset/url?q=askfdjaeei12
 * - Refer "ForgotPasswordObject" for request parameters.
 * - Success response - "Common Response", Possible status codes are SUCCESS, FAILED, MISSING_MANDATORY_FIELD, VALIDATION_FAILED, RECORD_NOT_EXISTS.
 *
 * @apiName ForgotPassword
 * @apiGroup User
 *
 * @apiExample Example Request:
 *    {
 *       "email": "yohan@gmail.com"
 *    }
 *
 */

/************ Reset Password *********/

/**
 * @api {post} http://<base-url>/api/user/reset-password Reset password
 * @apiDescription Reset user password. This is the second step of forgot password process.
 * - Refer "Reset Password Object" for request parameters.
 * - Success response - "Common Response". Possible status codes are SUCCESS, FAILED, MISSING_MANDATORY_FIELD, VALIDATION_FAILED, RECORD_NOT_EXISTS.
 *
 * @apiName ResetPassword
 * @apiGroup User
 *
 * @apiExample Example Request:
 *    {
 *       "passwordResetToken": "56ab8eae386c023",
 *       "password": "yohan@125"
 *    }
 *
 */

