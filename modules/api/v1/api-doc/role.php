<?php
/************ Create Role *********/

/**
 * @api {post} http://<base-url>/api/role Create Role
 * @apiDescription Add new role to the system. Use this method for create role.
 * - Refer "RoleObject" for necessary parameters. Following example illustrates the valid parameters for role creates.
 * Rest of the parameters described in "RoleObject" are used for viewing and some other requests.
 * - Response - "Common Response", possible response codes are SUCCESS, FAILED, PERMISSION_DENIED, MISSING_MANDATORY_FIELD,
 * NAME_EXISTS, EXCEED_CHARACTER_LIMIT
 * - Mandatory fields are
 * name, description , permissionName
 * - access-token required in header.
 *
 * @apiName Create
 * @apiGroup Role
 *
 * @apiExample Example Request:
 *    {
 *        {
 *            "name":"Update.Role",
 *            "description":"Creae Role",
 *            "Permissions":[
 *                   "Dashbord.Dashbord",
 *                   "Dashbord.video"
 *            ]
 *        }
 *    }
 */


/************ Update Role *********/

/**
 * @api {put} http://<base-url>/api/role/:name Update Role
 * @apiDescription Update existing role to the system. Use this method for Update role.
 * - Refer "RoleObject" for necessary parameters. Following example illustrates the valid parameters for role Update.
 * Rest of the parameters described in "RoleObject" are used for viewing and some other requests.
 * - Response - "Common Response", possible response codes are SUCCESS, FAILED, PERMISSION_DENIED, MISSING_MANDATORY_FIELD,
 * NAME_EXISTS, EXCEED_CHARACTER_LIMIT
 * - Mandatory fields are
 * name, description , permissionName
 * - access-token required in header.
 *
 * @apiName Update
 * @apiGroup Role
 *
 * @apiExample Example Request:
 *    {
 *        {
 *            "name":"Update.Role",
 *            "description":"Creae Role",
 *            "Permissions":[
 *                   "Dashbord.Dashbord",
 *                   "Dashbord.video"
 *            ]
 *        }
 *    }
 */

/************ Delete Permission *********/

/**
 * @api {delete} http://<base-url>/api/role/:name Delete Role
 * @apiDescription Delete existing role details.
 * - Success response - "Common Response" Possible response codes are SUCCESS, FAILED
 * AUTH_FAILED, RECORD_NOT_EXISTS, USER_IN_USE
 * - access-token required in header.
 *
 * @apiName Delete
 * @apiGroup Role
 *
 * @apiParam {string} name Role Name.
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

/************ Search Permission *********/

/**
 * @api {get} http://<base-url>/api/role-requests Get Role List
 * @apiDescription Search role by various parameters.
 * Success response - "Common Response", possible status codes are MISSING_MANDATORY_FIELD,
 * - RECORD_NOT_EXIST, AUTH_FAILED, FAILED
 * - access-token is required in header.
 *
 * @apiName Search
 * @apiGroup Role
 *
 * @apiParam {String} [name] Role Name.
 * @apiParam {String} [description] Description of the Role.
 * @apiParam {Number} [limit] Number of records to return. Default 10
 * @apiParam {Number} [page] Page number. Start form 1
 *
 * @apiSuccessExample Success-Response:
 *     {
 *         "code": "SUCCESS",
 *         "message": null,
 *         "data": {
 *                 "total": 1,
 *                 "permissions": [
 *                  {
 *                     "name": "Dashbord.Dashbord",
 *                     "description": "description manage",
 *                     "createdAt": "2017-09-06 07:49:56",
 *                     "updatedAt": null,
 *                     "createdById": null,
 *                     "updatedById": null
 *                 }
 *             ],
 *         },
 *     }
 *
 */

/************ View Role *********/

/**
 * @api {get} http://<base-url>/api/role/:name View Role
 * @apiDescription Retrieve existing role and permission information.
 * - Success response - "Common Response Object" Possible response codes are SUCCESS, RECORD_NOT_EXISTS , AUTH_FAILED .
 * - access-token required in header.
 *
 * @apiName View
 * @apiGroup Role
 *
 * @apiParam {string} name Role name.
 *
 * @apiExample Example Response:
 *
 *    {
 *        "code": "SUCCESS",
 *        "message": null,
 *        "data": {
 *             "role": {
 *                 "name": "Dashboard.Dashboard",
 *                 "description": "Property manage",
 *                 "createdAt": "2017-09-03 04:41:57",
 *                 "updatedAt": "2017-09-04 10:44:21",
 *                 "createdById": null,
 *                 "updatedById": null,
 *                 "permissions": [
 *                      "Dashbord.Dashbordtwo"
 *                 ]
 *             }
 *         },
 *         "attribute": null
 *    }
 */