<?php
/************ Create Permission *********/

/**
 * @api {post} http://<base-url>/api/permission Create Permission
 * @apiDescription Add new permission to the system. Use this method for create permission.
 * - Refer "PermissionObject" for necessary parameters. Following example illustrates the valid parameters for permission creates.
 * Rest of the parameters described in "PermissionObject" are used for viewing and some other requests.
 * - Response - "Common Response", possible response codes are SUCCESS, FAILED, PERMISSION_DENIED, MISSING_MANDATORY_FIELD,
 * NAME_EXISTS, EXCEED_CHARACTER_LIMIT
 * - Mandatory fields are
 * name, description, category
 * - access-token required in header.
 *
 * @apiName Create
 * @apiGroup Permission
 *
 * @apiExample Example Request:
 *    {
 *        "name": "Dashboard.Dashboard",
 *        "description": "Property manage",
 *        "category": "Property",
 *    }
 */

/************ View Permission *********/

/**
 * @api {get} http://<base-url>/api/permission/:name View Permission
 * @apiDescription Retrieve existing permission information.
 * - Success response - "Common Response Object" Possible response codes are SUCCESS, RECORD_NOT_EXISTS , AUTH_FAILED .
 * - access-token required in header.
 *
 * @apiName View
 * @apiGroup Permission
 *
 * @apiParam {string} name Permission name.
 *
 * @apiExample Example Response:
 *
 *    {
 *        "code": "SUCCESS",
 *        "message": null,
 *        "data": {
 *             "permission": {
 *                 "name": "Dashboard.Dashboard",
 *                 "description": "Property manage",
 *                 "category": "Property",
 *                 "createdAt": "2017-09-03 04:41:57",
 *                 "updatedAt": "2017-09-04 10:44:21",
 *                 "createdById": null,
 *                 "updatedById": null,
 *             }
 *         },
 *         "attribute": null
 *    }
 */

/************ Update Permission *********/

/**
 * @api {put} http://<base-url>/api/permission/:name Update Permission
 * @apiDescription Update existing permission details.
 * - Success response - "Common Response" Possible response codes are SUCCESS, FAILED, MISSING_MANDATORY_FIELD,
 * AUTH_FAILED, RECORD_NOT_EXISTS, EXCEED_CHARACTER_LIMIT, FAILED
 * - access-token required in header.
 *
 * @apiName Update
 * @apiGroup Permission
 *
 * @apiParam {string} name Permission Name.
 *
 * @apiExample Example Request:
 *
 *    {
 *        "name": "Dashboard.Dashboard",
 *        "description": "Property manage",
 *        "category": "Property",
 *    }
 */

/************ Delete Permission *********/

/**
 * @api {delete} http://<base-url>/api/permission/:name Delete Permission
 * @apiDescription Delete existing permission details.
 * - Success response - "Common Response" Possible response codes are SUCCESS, FAILED, MISSING_MANDATORY_FIELD,
 * AUTH_FAILED, RECORD_NOT_EXISTS, EXCEED_CHARACTER_LIMIT, PERMISSION_IN_USE
 * - access-token required in header.
 *
 * @apiName Delete
 * @apiGroup Permission
 *
 * @apiParam {string} name Permission Name.
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
 * @api {get} http://<base-url>/api/permission-requests Get Permission List
 * @apiDescription Search permission by various parameters.
 * Success response - "Common Response", possible status codes are MISSING_MANDATORY_FIELD,
 * - RECORD_NOT_EXIST, AUTH_FAILED, FAILED
 * - access-token is required in header.
 *
 * @apiName Search
 * @apiGroup Permission
 *
 * @apiParam {String} [name] Property code.
 * @apiParam {String} [description] Description of the permission.
 * @apiParam {String} [category] Category of the permission.
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
 *                     "category": "create",
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