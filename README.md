**RTC Cloud User Guide**
====================

Shared Document Management
--------------------------

### 1.1 Public Documents

Public documents are a team collaboration space for storing business files of the organization. You can customize folder types and names based on your organization's business needs.

Log in to the Curious Bird admin panel, then go to Document Management> Document Storage.
![avatar](/img/1.png)

### 1.2 Permissions

You can add or remove permissions for the selected directory. After adding permissions, employees in the department will have the selected permissions.

Display: Users can view folder and file names in their directory (without viewing file contents).

View: Users can view documents, images, videos, and audio online through the web.

Edit: Users can edit documents online through the web.

Move: Users can move folders or files from one directory to another within the same directory.

Download: Users can download folders or files from their current directory to their local device.

Create: Users can create subfolders or upload files in their directory. If they do not have this permission, the administrator must approve the upload.

Delete: Users can delete subfolders or files in their current directory.

Rename: Users can rename subfolders or files in their directory.

Share: Users can create a share link for subfolders or uploaded files in their current directory.

Permissions: Users can set root directory permissions in subfolders of their current directory.

### 1.3 Permission Inheritance

![avatar](/img/2.png)
![avatar](/img/3.png)

If Three-level directory 1 has the Finance permission, all employees in "Finance" will have the same permission in Three-level directory 1.

If both the Finance and Zhang San permissions are added to Three-level directory 1, the permissions added to Zhang San will take precedence.

If Three-level directory 1 grants permissions to Zhang San, then Zhang San's permissions are those set by Three-level directory 1. If Three-level directory 1 does not grant permissions to Zhang San, check whether Subdirectory 2 has set permissions for Zhang San. If Subdirectory 2 has set permissions, then Zhang San's permissions are those set by Subdirectory 2. If Subdirectory 2 does not have set permissions, check whether First-level directory 1 has set permissions for Zhang San. If First-level directory 1 has set permissions, then Zhang San's permissions are those set by First-level directory 1.

Therefore, when there are multiple subdirectories, you only need to set the root directory permissions, and the subdirectories will automatically inherit them.

If First-level directory 1 does not have access to Zhang San, Zhang San cannot view this directory when accessing the cloud drive. Therefore, even if you set permissions for subdirectories and sub-subdirectories, they will not be visible.

If you want Zhang San to view only Three-level directory 1 and not other directories, add permissions to Three-level directory 1 and leave other directories blank (as shown in the figure below).

If you do not want Zhang San to view Three-level directory 1 but allow him to view other directories, grant Three-level directory 1 access and leave other directories blank.
![avatar](/img/4.png)

### 1.4 Show cloud drive files

Log in and go to Admin Console, System Settings-Server Settings.

When certain employees are denied access to specific directories, items such as Documents, Photos, Music, Videos, Recent Updates, and Search Results may still display files from those directories. In such cases, you need to refine the permission settings.

Some sections of the public document are not displayed: After checking, the public document, images, music, videos, recent updates, and search results will not be displayed. After checking and setting the display personnel, others will not see the document, but the set personnel will see it.

Some sections in public documents are not displayed if you do not have viewing permissions: Public Documents, Images, Music, Videos, Recent Updates, and Search Results. If you do not have viewing permissions for the document's directory, the document will not be displayed (enabling this will increase server load).

### 1.5 WPS Drive file review

When users lack upload permissions, their files require administrator approval to appear in WPS Drive.

Log in to the admin panel, go to Query and Statistics> Public Documents to view all public cloud drive documents.

After the user-uploaded file passes the review (check the status checkbox), it will appear in the shared document for other employees to download.
![avatar](/img/5.png)

### 1.6 Admin uploads files

After adding the root directory to the Public Documents, open the WPS Drive web version (http://127.0.0.1:98/cloud/account/login.html?gourl=../include/yunpan.html#public) to upload files, or use the Import File tool directly.
Online Document Management

--------------------------

### 2.1 Online Documents

Online Docs is a collaborative document creation tool that supports real-time editing of Word, Excel, and PPT documents online, with automatic cloud-saving.

### 2.2 Permissions

After opening the online document, click "Permissions" in the upper right corner of the page to set which employees can edit, which can only view, and which cannot view.

![avatar](/img/6.png)

### 2.3 Default Permissions

Offline files: Word, Excel, or PowerPoint files exchanged between Curious Bird RTC are opened with both parties having default editing permissions.

Group files: Word, Excel, or PowerPoint files uploaded to a group created via Qiniu Bird RTC. When opened as an online document, all group members have default editing permissions.

Shared Files: Access the shared folder created via the Curious Bird RTC File Assistant (third button at the bottom of the main interface). All Word, Excel, and PowerPoint files uploaded to this folder are editable by all members by default when opened as online documents.



### 3 Demo

Client download address:
http://t.rtcim.com:98/download.html

Test account:

Account:admin

Password:123

Network (to be filled in by the client, no need to open in the browser): t.rtcim.com

Backend login address:

http://t.rtcim.com:98/admin/account/login.html

admin

123

Both internal and external networks can be used
Private Cloud Deployment
All data is stored on your own servers
You can use any company intranet computer as a server, with the configuration of Core I5.
