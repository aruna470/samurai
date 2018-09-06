<?php
/************ Create Video Activity *********/

/**
 * @api {post} http://<base-url>/video-activity Create Video Activity
 * @apiDescription Add new Video Activity to the system. Use this method for create Video Activity.
 * - Refer "videoActivityObject" for necessary parameters. Following example illustrates the valid parameters for VideoActivity creates.
 * Rest of the parameters described in "VideoActivityObject" are used for viewing and some other requests.
 * - Response - "Common Response", possible response codes are SUCCESS, FAILED, PERMISSION_DENIED, MISSING_MANDATORY_FIELD,
 * AUTH_FAILED, EXCEED_CHARACTER_LIMIT
 * - Mandatory fields are
 * videoRefId, deviceId
 * - access-token required in header.
 *
 * @apiName Create
 * @apiGroup VideoActivity
 *
 * @apiExample Example Request:
 *    {
 *        "videoRefId": "Dashboard.Dashboard",
 *        "deviceId": "Property manage",
 *        "status":1
 *    }
 */