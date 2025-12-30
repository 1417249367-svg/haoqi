/****** Object:  Table [dbo].[yfsdl]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[yfsdl](
	[Id] [int] NULL,
	[Mobile] [nvarchar](15) NOT NULL,
	[Content] [nvarchar](255) NOT NULL,
	[Deadtime] [datetime] NOT NULL,
	[Status] [int] NOT NULL,
	[msgid] [int] NULL,
	[ImUserID] [nvarchar](20) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[WeatherForm]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[WeatherForm](
	[ToDate] [nvarchar](10) NOT NULL,
	[Temperature] [nvarchar](40) NULL,
	[Morning] [nvarchar](40) NULL,
	[Evening] [nvarchar](40) NULL,
	[Weico] [tinyint] NULL,
	[ToTime] [datetime] NULL,
	[City] [nvarchar](20) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Users_WinInfo]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Users_WinInfo](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[WindowsInfo] [nvarchar](200) NULL,
	[UserName] [nvarchar](20) NULL,
	[Upan] [nvarchar](50) NULL,
	[LocalIP] [nvarchar](50) NULL,
	[UserIcoLine] [tinyint] NULL,
 CONSTRAINT [PK_Users_WinInfo] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Users_Role]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Users_Role](
	[UserID] [nvarchar](50) NULL,
	[RoleID] [int] NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Users_Ro]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Users_Ro](
	[TypeID] [nvarchar](20) NOT NULL,
	[TypeName] [nvarchar](200) NULL,
	[ParentID] [nvarchar](50) NULL,
	[Description] [nvarchar](max) NULL,
	[ItemIndex] [nvarchar](50) NULL,
	[CreatorID] [nvarchar](50) NULL,
	[CreatorName] [nvarchar](200) NULL,
 CONSTRAINT [PK_Users_Ro] PRIMARY KEY CLUSTERED 
(
	[TypeID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Users_Pic]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Users_Pic](
	[UserID] [nvarchar](20) NOT NULL,
	[pic] [int] NULL,
	[Sfile] [int] NULL,
 CONSTRAINT [PK_Users_Pic] PRIMARY KEY CLUSTERED 
(
	[UserID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Users_ID]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Users_ID](
	[UppeID] [nvarchar](200) NOT NULL,
	[UserID] [nvarchar](20) NOT NULL,
	[UserName] [nvarchar](200) NULL,
	[UserPaws] [nvarchar](200) NULL,
	[FcName] [nvarchar](200) NULL,
	[Age] [nvarchar](5) NULL,
	[Jod] [nvarchar](200) NULL,
	[Tel1] [nvarchar](20) NULL,
	[Tel2] [nvarchar](20) NULL,
	[Address] [nvarchar](200) NULL,
	[Say] [nvarchar](max) NULL,
	[UserIco] [tinyint] NULL,
	[UserIcoLine] [tinyint] NULL,
	[School] [nvarchar](200) NULL,
	[Effigy] [nvarchar](200) NULL,
	[Constellation] [nvarchar](200) NULL,
	[remark] [nvarchar](200) NULL,
	[Sequence] [int] NULL,
	[binding] [bit] NOT NULL,
	[LoginTime] [datetime] NULL,
	[UserState] [int] NULL,
	[NetworkIP] [nvarchar](50) NULL,
	[LocalIP] [nvarchar](50) NULL,
	[Mac] [nvarchar](200) NULL,
	[Registration_Id] [nvarchar](200) NULL,
	[PlatForm] [nvarchar](50) NULL,
	[ManuFacturer] [nvarchar](50) NULL,
	[LocalIPList] [nvarchar](200) NULL,
	[MacList] [nvarchar](200) NULL,
	[IsVerify] [int] NULL,
	[IsManager] [int] NULL,
	[Fav_FormVesr] [int] NULL,
	[Col_FormVesr] [int] NULL,
	[Users_IDVesr] [int] NULL,
	[CreatorID] [nvarchar](50) NULL,
	[CreatorName] [nvarchar](200) NULL,
	[ExpireTime] [bigint] NULL,
 CONSTRAINT [PK_Users_ID] PRIMARY KEY CLUSTERED 
(
	[UserID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[UpDateForm]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[UpDateForm](
	[ID] [int] NULL,
	[Users_RoVesr] [int] NULL,
	[Users_IDVesr] [int] NULL,
	[Clot_RoVesr] [int] NULL,
	[Clot_FormVesr] [int] NULL,
	[ClotFile_Vesr] [int] NULL,
	[SecInfoVesr] [int] NULL,
	[Tel_FormVesr] [int] NULL,
	[PtpFile_Vesr] [int] NULL,
	[PtpFolder_Vesr] [int] NULL,
	[PtpForm_Vesr] [int] NULL,
	[LeaveFile_Vesr] [int] NULL,
	[NewGo_Vesr] [int] NULL,
	[NewRo_Vesr] [int] NULL,
	[MyTel_RoVesr] [int] NULL,
	[MyTel_FormVesr] [int] NULL,
	[Plug_Vesr] [int] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[ToInfo]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ToInfo](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[TO_Date] [datetime] NULL,
	[To_Time] [datetime] NULL,
	[To_Txt] [nvarchar](max) NULL,
	[FontInfo] [nvarchar](50) NULL,
 CONSTRAINT [PK_ToInfo] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Tel_Form]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Tel_Form](
	[UppeID] [nvarchar](20) NOT NULL,
	[TypeID] [int] IDENTITY(1,1) NOT NULL,
	[PaName] [nvarchar](20) NOT NULL,
	[TelName] [nvarchar](20) NULL,
	[TelIco] [tinyint] NULL,
	[Telete1] [nvarchar](40) NULL,
	[Telete2] [nvarchar](40) NULL,
	[Remark] [nvarchar](100) NULL,
	[To_Date] [datetime] NULL,
 CONSTRAINT [PK_Tel_Form] PRIMARY KEY CLUSTERED 
(
	[TypeID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Tab_Meet_Msg_XXX]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Tab_Meet_Msg_XXX](
	[Col_MeetID] [nvarchar](38) NOT NULL,
	[Col_MsgID] [nvarchar](38) NOT NULL,
	[Col_SendLogin] [nvarchar](80) NOT NULL,
	[Col_SendName] [nvarchar](50) NOT NULL,
	[Col_Date] [datetime] NOT NULL,
	[Col_Content] [nvarchar](512) NOT NULL,
	[Col_ContentType] [nvarchar](50) NOT NULL,
	[Col_DataPath] [nvarchar](50) NOT NULL,
 CONSTRAINT [PK_Tab_Meet_Msg_XXX] PRIMARY KEY CLUSTERED 
(
	[Col_MeetID] ASC,
	[Col_MsgID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Tab_Meet_Member]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Tab_Meet_Member](
	[Col_MeetID] [nvarchar](38) NOT NULL,
	[Col_UserLogin] [nvarchar](80) NULL,
	[Col_UserName] [nvarchar](50) NULL,
	[Col_UserID] [int] NOT NULL,
	[Col_JoinState] [smallint] NULL,
	[Col_JoinTime] [datetime] NULL,
	[Col_IsAdmin] [int] NULL,
	[Col_LastMsgTime] [datetime] NULL,
	[Col_socketId] [nvarchar](200) NULL,
	[Col_LoginType] [smallint] NULL,
	[Col_IsAudio] [smallint] NULL,
	[Col_IsVideo] [smallint] NULL,
	[Col_State] [smallint] NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Tab_Meet_File_Group]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Tab_Meet_File_Group](
	[Col_MeetID] [nvarchar](38) NOT NULL,
	[Col_Name] [nvarchar](80) NOT NULL,
 CONSTRAINT [PK_Tab_Meet_File_Group] PRIMARY KEY CLUSTERED 
(
	[Col_MeetID] ASC,
	[Col_Name] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Tab_Meet_File]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Tab_Meet_File](
	[Col_MeetID] [nvarchar](38) NOT NULL,
	[Col_FileID] [nvarchar](38) NOT NULL,
	[Col_FileName] [nvarchar](255) NOT NULL,
	[Col_FileSize] [bigint] NOT NULL,
	[Col_FileSName] [nvarchar](50) NOT NULL,
	[Col_FileType] [smallint] NOT NULL,
	[Col_SendLogin] [nvarchar](80) NOT NULL,
	[Col_SendName] [nvarchar](50) NOT NULL,
	[Col_SendDate] [datetime] NOT NULL,
	[Col_DownCount] [int] NULL,
	[Col_Group] [nvarchar](80) NULL,
 CONSTRAINT [PK_Tab_Meet_File] PRIMARY KEY CLUSTERED 
(
	[Col_MeetID] ASC,
	[Col_FileID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Tab_Meet]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Tab_Meet](
	[Col_ID] [nvarchar](38) NOT NULL,
	[Col_Name] [nvarchar](50) NOT NULL,
	[Col_Desc] [nvarchar](128) NULL,
	[Col_Notice] [nvarchar](255) NULL,
	[Col_CreateLogin] [nvarchar](80) NULL,
	[Col_CreateName] [nvarchar](50) NULL,
	[Col_CreateID] [int] NULL,
	[Col_CreateDate] [datetime] NULL,
	[Col_IsDelete] [bit] NULL,
	[Col_Type] [smallint] NULL,
	[Col_JoinVerify] [smallint] NULL,
	[Col_Genre] [nvarchar](50) NULL,
	[Col_UserCount] [smallint] NULL,
	[Col_MsgIndex] [smallint] NULL,
	[Col_DomainID] [nvarchar](50) NULL,
	[Col_IsAudio] [smallint] NULL,
	[Col_IsVideo] [smallint] NULL,
	[Col_State] [smallint] NULL,
	[Col_SchDate] [datetime] NULL,
 CONSTRAINT [PK_Tab_Meet] PRIMARY KEY CLUSTERED 
(
	[Col_ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Tab_Config]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS OFF
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING OFF
GO
CREATE TABLE [dbo].[Tab_Config](
	[Col_Name] [nvarchar](50) NULL,
	[Col_Data] [nvarchar](max) NULL,
	[Col_Genre] [nvarchar](50) NULL,
	[col_AntServer] [nvarchar](50) NULL,
	[col_LoginName] [nvarchar](50) NULL,
	[col_HsItemID] [int] NULL,
	[col_HsItemType] [int] NULL,
	[Col_PackageName] [nvarchar](50) NULL,
	[Col_Disabled] [bit] NULL,
	[Col_ID] [int] IDENTITY(1,1) NOT NULL,
 CONSTRAINT [PK_Tab_Config] PRIMARY KEY CLUSTERED 
(
	[Col_ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Tab_Chat]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Tab_Chat](
	[ChatId] [int] NOT NULL,
	[GroupId] [int] NULL,
	[MyID] [nvarchar](50) NULL,
	[YouID] [nvarchar](50) NULL,
	[UserName] [nvarchar](50) NULL,
	[IP] [nvarchar](50) NULL,
	[Area] [nvarchar](50) NULL,
	[InTime] [datetime] NULL,
	[ConnectTime] [datetime] NOT NULL,
	[OutTime] [datetime] NULL,
	[socketId] [nvarchar](200) NULL,
	[IsAudio] [smallint] NULL,
	[IsVideo] [smallint] NULL,
	[LoginType1] [smallint] NULL,
	[LoginType2] [smallint] NULL,
	[IsAudio1] [smallint] NULL,
	[IsVideo1] [smallint] NULL,
	[IsAudio2] [smallint] NULL,
	[IsVideo2] [smallint] NULL,
	[Status] [int] NULL,
	[CloseRole] [int] NULL,
	[Rate] [int] NULL,
	[RateNote] [nvarchar](500) NULL,
	[AllowUploadFile] [int] NULL,
	[NContent] [nvarchar](500) NULL,
	[Ord] [int] NULL,
 CONSTRAINT [PK_Tab_Chat] PRIMARY KEY CLUSTERED 
(
	[ChatId] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[ServerLog]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ServerLog](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[Todate] [datetime] NULL,
	[Txt] [nvarchar](100) NULL,
	[UserID] [nvarchar](20) NULL,
	[Ip] [nvarchar](50) NULL,
	[Ico] [int] NULL,
	[To_Type] [int] NULL,
 CONSTRAINT [PK_ServerLog] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[ServerErrLog]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ServerErrLog](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[Todate] [nvarchar](50) NULL,
	[Err1] [nvarchar](200) NULL,
	[Err2] [nvarchar](200) NULL,
 CONSTRAINT [PK_ServerErrLog] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[SecInfo]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[SecInfo](
	[TypeID] [int] IDENTITY(1,1) NOT NULL,
	[InfoTime] [nvarchar](5) NOT NULL,
	[Remark] [nvarchar](max) NULL,
 CONSTRAINT [PK_SecInfo] PRIMARY KEY CLUSTERED 
(
	[TypeID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[rtc_sms_address]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[rtc_sms_address](
	[col_id] [int] IDENTITY(1,1) NOT NULL,
	[col_name] [nvarchar](50) NULL,
	[col_mobile] [nvarchar](50) NULL,
	[col_owner] [nvarchar](50) NULL,
 CONSTRAINT [PK_ANT_SMS_ADDRESS] PRIMARY KEY CLUSTERED 
(
	[col_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[rtc_sms_account]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[rtc_sms_account](
	[Col_ID] [int] IDENTITY(1,1) NOT NULL,
	[Col_account] [nvarchar](50) NULL,
	[Col_password] [nvarchar](50) NULL,
	[Col_emp_type] [int] NULL,
	[Col_emp_id] [int] NULL,
	[Col_emp_name] [nvarchar](255) NULL,
	[Col_Creator_ID] [int] NULL,
	[Col_Creator_Name] [nvarchar](50) NULL,
	[Col_Dt_Create] [datetime] NOT NULL,
 CONSTRAINT [PK_Ant_sms_account] PRIMARY KEY CLUSTERED 
(
	[Col_ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[rtc_sms]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS OFF
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING OFF
GO
CREATE TABLE [dbo].[rtc_sms](
	[col_id] [int] IDENTITY(1,1) NOT NULL,
	[col_content] [nvarchar](1024) NULL,
	[col_recv_mobile] [nvarchar](1024) NULL,
	[col_recv_name] [nvarchar](max) NULL,
	[col_send_name] [nvarchar](50) NULL,
	[col_send_time] [nvarchar](50) NULL,
	[col_send_url] [nvarchar](max) NULL,
	[col_creator_id] [int] NULL,
	[col_creator_name] [nvarchar](50) NULL,
	[col_dt_create] [datetime] NOT NULL,
	[col_status] [int] NULL,
	[col_return] [nvarchar](255) NULL,
	[col_flag] [int] NULL,
	[col_send_loginname] [nvarchar](50) NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[rtc_keyword]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[rtc_keyword](
	[col_id] [nvarchar](50) NOT NULL,
	[col_type] [int] NOT NULL,
	[col_keyword] [nvarchar](1024) NOT NULL,
	[col_date] [nvarchar](20) NULL,
 CONSTRAINT [PK_ant_keyword] PRIMARY KEY CLUSTERED 
(
	[col_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Role]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Role](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[RoleName] [nvarchar](50) NULL,
	[Description] [nvarchar](max) NULL,
	[Permissions] [nvarchar](200) NULL,
	[Plug] [nvarchar](200) NULL,
	[PtpSize] [int] NULL,
	[PtpType] [nvarchar](200) NULL,
	[PubSize] [int] NULL,
	[PubType] [nvarchar](200) NULL,
	[ClotSize] [int] NULL,
	[ClotType] [nvarchar](200) NULL,
	[UsersSize] [int] NULL,
	[UsersType] [nvarchar](200) NULL,
	[DepartmentPermission] [int] NULL,
	[Department] [nvarchar](max) NULL,
	[SmsCount] [int] NULL,
	[DefaultRole] [int] NULL,
	[CreatorID] [nvarchar](50) NULL,
	[CreatorName] [nvarchar](200) NULL,
 CONSTRAINT [PK_Role] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[remote_chat]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[remote_chat](
	[ChatId] [int] NOT NULL,
	[GroupId] [int] NULL,
	[MyID] [nvarchar](50) NULL,
	[YouID] [nvarchar](50) NULL,
	[UserName] [nvarchar](50) NULL,
	[IP] [nvarchar](50) NULL,
	[Area] [nvarchar](50) NULL,
	[InTime] [datetime] NULL,
	[ConnectTime] [datetime] NOT NULL,
	[OutTime] [datetime] NULL,
	[Status] [int] NULL,
	[CloseRole] [int] NULL,
	[Rate] [int] NULL,
	[RateNote] [nvarchar](500) NULL,
	[AllowUploadFile] [int] NULL,
	[NContent] [nvarchar](500) NULL,
	[Ord] [int] NULL,
 CONSTRAINT [PK_remote_chat] PRIMARY KEY CLUSTERED 
(
	[ChatId] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[PtpForm]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[PtpForm](
	[MyID] [nvarchar](20) NULL,
	[UserID] [nvarchar](20) NULL,
	[PtpFolderID] [nvarchar](50) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[PtpFolderForm]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[PtpFolderForm](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[MyID] [nvarchar](20) NULL,
	[UserID] [nvarchar](20) NULL,
	[To_Type] [int] NULL,
	[DocAce] [int] NULL,
	[PtpFolderID] [nvarchar](50) NULL,
	[ToDate] [datetime] NULL,
	[ToTime] [datetime] NULL,
 CONSTRAINT [PK_PtpFolderForm] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[PtpFolder]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[PtpFolder](
	[PtpFolderID] [int] IDENTITY(1,1) NOT NULL,
	[MyID] [nvarchar](50) NULL,
	[UsName] [nvarchar](512) NULL,
	[ParentID] [nvarchar](50) NULL,
	[ToDate] [datetime] NULL,
	[ToTime] [datetime] NULL,
	[To_Type] [smallint] NULL,
	[CreatorID] [nvarchar](50) NULL,
	[CreatorName] [nvarchar](200) NULL,
 CONSTRAINT [PK_PtpFolder] PRIMARY KEY CLUSTERED 
(
	[PtpFolderID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[PtpFile]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[PtpFile](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[Msg_ID] [nvarchar](255) NULL,
	[MyID] [nvarchar](10) NULL,
	[UsName] [nvarchar](50) NULL,
	[TypePath] [nvarchar](512) NULL,
	[PcSize] [nvarchar](50) NULL,
	[ToDate] [datetime] NULL,
	[ToTime] [datetime] NULL,
	[PtpFolderID] [nvarchar](50) NULL,
	[FilPath] [nvarchar](512) NULL,
	[To_Type] [smallint] NULL,
	[OnlineID] [int] NULL,
	[FileState] [int] NULL,
	[CreatorID] [nvarchar](50) NULL,
	[CreatorName] [nvarchar](200) NULL,
 CONSTRAINT [PK_PtpFile] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[PlugVesr]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[PlugVesr](
	[Plug_Bie] [int] NULL,
	[Plug_Vesr] [int] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Plug]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Plug](
	[Plug_ID] [int] IDENTITY(1,1) NOT NULL,
	[Plug_Name] [nvarchar](50) NULL,
	[Plug_Site] [nvarchar](50) NULL,
	[Plug_Height] [nvarchar](50) NULL,
	[Plug_Width] [nvarchar](50) NULL,
	[Plug_TargetType] [nvarchar](50) NULL,
	[Plug_Target] [nvarchar](max) NULL,
	[Plug_DisplayName] [nvarchar](50) NULL,
	[Plug_Desc] [nvarchar](max) NULL,
	[Plug_Param] [nvarchar](max) NULL,
	[Plug_Image] [nvarchar](max) NULL,
	[Plug_Enabled] [bit] NOT NULL,
	[Plug_Index] [int] NULL,
	[Plug_Bie] [int] NULL,
 CONSTRAINT [PK_Plug] PRIMARY KEY CLUSTERED 
(
	[Plug_ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[OtherForm]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[OtherForm](
	[ID] [tinyint] NOT NULL,
	[Paws] [nvarchar](20) NOT NULL,
	[SUpDate] [nvarchar](50) NULL,
	[WebName] [nvarchar](50) NULL,
	[WebUrl] [nvarchar](max) NULL,
	[WebRun] [int] NULL,
	[Logo] [int] NULL,
	[OneRun] [nvarchar](50) NULL,
	[RuDate] [nvarchar](50) NULL,
	[RuDate1] [nvarchar](50) NULL,
	[RuDate2] [nvarchar](50) NULL,
	[RuDate3] [nvarchar](50) NULL,
	[LastRun] [nvarchar](50) NULL,
	[UserCount] [nvarchar](50) NULL,
	[YesID] [nvarchar](50) NULL,
	[YesID1] [nvarchar](50) NULL,
	[YesID2] [nvarchar](50) NULL,
	[YesID3] [nvarchar](50) NULL,
	[UpDateTime] [nvarchar](50) NULL,
	[UserApply] [int] NULL,
	[IPAddress] [nvarchar](50) NULL,
	[User_ID] [nvarchar](max) NULL,
	[WebCode] [nvarchar](max) NULL,
	[welcome] [nvarchar](50) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[OnlineRevisedFile]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[OnlineRevisedFile](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[MyID] [nvarchar](10) NULL,
	[UsName] [nvarchar](50) NULL,
	[TypePath] [nvarchar](512) NULL,
	[PcSize] [nvarchar](50) NULL,
	[ToDate] [datetime] NULL,
	[ToTime] [datetime] NULL,
	[OnlineID] [int] NULL,
	[FilPath] [nvarchar](512) NULL,
	[Description] [nvarchar](255) NULL,
	[CallbackJSON] [nvarchar](max) NULL,
	[CreatorID] [nvarchar](50) NULL,
	[CreatorName] [nvarchar](200) NULL,
 CONSTRAINT [PK_OnlineRevisedFile] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[OnlineHeat]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[OnlineHeat](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[MyID] [nvarchar](50) NULL,
	[OnlineID] [int] NULL,
	[ToDate] [datetime] NULL,
	[ToTime] [datetime] NULL,
	[IsTop] [int] NULL,
 CONSTRAINT [PK_OnlineHeat] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[OnlineForm]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[OnlineForm](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[MyID] [nvarchar](20) NULL,
	[UserID] [nvarchar](20) NULL,
	[Authority] [int] NULL,
	[OnlineID] [int] NULL,
	[ToDate] [datetime] NULL,
	[ToTime] [datetime] NULL,
	[IsTop] [int] NULL,
 CONSTRAINT [PK_OnlineForm] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[OnlineFile]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[OnlineFile](
	[OnlineID] [int] IDENTITY(1,1) NOT NULL,
	[MyID] [nvarchar](50) NULL,
	[UsName] [nvarchar](50) NULL,
	[TypePath] [nvarchar](512) NULL,
	[PcSize] [nvarchar](50) NULL,
	[ToDate] [datetime] NULL,
	[ToTime] [datetime] NULL,
	[FilPath] [nvarchar](512) NULL,
	[FormFileType] [smallint] NULL,
	[Authority1] [int] NULL,
	[Authority2] [int] NULL,
	[Authority3] [int] NULL,
	[IsTop] [int] NULL,
	[FileState] [int] NULL,
 CONSTRAINT [PK_OnlineFile] PRIMARY KEY CLUSTERED 
(
	[OnlineID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Notice_Acks]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Notice_Acks](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[Msg_ID] [nvarchar](255) NULL,
	[MyID] [nvarchar](20) NULL,
	[YouID] [nvarchar](20) NULL,
	[IsAck1] [int] NULL,
	[IsAck2] [int] NULL,
	[To_Date] [datetime] NULL,
 CONSTRAINT [PK_Notice_Acks] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[News_Ro]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[News_Ro](
	[MyID] [nvarchar](20) NULL,
	[UserID] [nvarchar](20) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[News_Form]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[News_Form](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[UserID] [nvarchar](20) NULL,
	[FcName] [nvarchar](50) NULL,
	[Motif] [nvarchar](120) NULL,
	[NContent] [nvarchar](max) NULL,
	[Tel] [nvarchar](50) NULL,
	[ToDate] [datetime] NULL,
	[ToType] [int] NULL,
	[LookOver] [smallint] NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[MyTel_Ro]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[MyTel_Ro](
	[UpperID] [nvarchar](20) NOT NULL,
	[TypeID] [nvarchar](20) NOT NULL,
	[TypeName] [nvarchar](20) NULL,
 CONSTRAINT [PK_MyTel_Ro] PRIMARY KEY CLUSTERED 
(
	[TypeID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[MyTel_Form]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[MyTel_Form](
	[UpperID] [nvarchar](20) NOT NULL,
	[TelID] [nvarchar](50) NOT NULL,
	[TelName] [nvarchar](20) NOT NULL,
	[TelIco] [tinyint] NULL,
	[Tel1] [nvarchar](50) NULL,
	[Tel2] [nvarchar](50) NULL,
	[Tel3] [nvarchar](50) NULL,
	[Email] [nvarchar](50) NULL,
	[Rek] [nvarchar](255) NULL,
	[ToDate] [datetime] NULL,
 CONSTRAINT [PK_MyTel_Form] PRIMARY KEY CLUSTERED 
(
	[TelID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Msg_Acks]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Msg_Acks](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[Msg_ID] [nvarchar](255) NULL,
	[ClotID] [nvarchar](20) NULL,
	[MyID] [nvarchar](20) NULL,
	[YouID] [nvarchar](20) NULL,
	[IsReceipt1] [int] NULL,
	[IsReceipt2] [int] NULL,
	[To_Date] [datetime] NULL,
	[To_Time] [datetime] NULL,
 CONSTRAINT [PK_Msg_Acks] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[MessengVerify_Type]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[MessengVerify_Type](
	[TypeID] [int] IDENTITY(1,1) NOT NULL,
	[UserID1] [nvarchar](20) NOT NULL,
	[ClotID] [nvarchar](50) NULL,
	[UserID2] [nvarchar](20) NOT NULL,
	[UserText] [nvarchar](max) NULL,
	[TO_IP] [nvarchar](20) NULL,
	[TO_Date] [datetime] NULL,
	[To_Type1] [int] NULL,
	[To_Type2] [int] NULL,
	[To_Type3] [int] NULL,
	[To_Type4] [int] NULL,
 CONSTRAINT [PK_MessengVerify_Type] PRIMARY KEY CLUSTERED 
(
	[TypeID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[MessengVerify_Blacklist]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[MessengVerify_Blacklist](
	[TypeID] [int] IDENTITY(1,1) NOT NULL,
	[MyID] [nvarchar](20) NOT NULL,
	[YouID] [nvarchar](20) NOT NULL,
	[TO_IP] [nvarchar](20) NULL,
	[TO_Date] [datetime] NULL,
	[To_Type] [int] NULL,
 CONSTRAINT [PK_MessengVerify_Blacklist] PRIMARY KEY CLUSTERED 
(
	[TypeID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[MessengTel_Text]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[MessengTel_Text](
	[TypeID] [int] IDENTITY(1,1) NOT NULL,
	[MyID] [nvarchar](20) NULL,
	[Telete] [nvarchar](20) NULL,
	[FcName] [nvarchar](20) NULL,
	[To_Type] [smallint] NULL,
	[To_Date] [datetime] NULL,
	[To_Time] [datetime] NULL,
	[UserText] [nvarchar](max) NULL,
 CONSTRAINT [PK_MessengTel_Text] PRIMARY KEY CLUSTERED 
(
	[TypeID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[MessengNotice_Text]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[MessengNotice_Text](
	[TypeID] [int] IDENTITY(1,1) NOT NULL,
	[Msg_ID] [nvarchar](255) NULL,
	[MyID] [nvarchar](50) NULL,
	[YouID] [nvarchar](50) NULL,
	[Ntitle] [nvarchar](50) NULL,
	[Ncontent] [nvarchar](max) NULL,
	[Nlink] [nvarchar](max) NULL,
	[TO_IP] [nvarchar](50) NULL,
	[To_Date] [datetime] NULL,
 CONSTRAINT [PK_MessengNotice_Type] PRIMARY KEY CLUSTERED 
(
	[TypeID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[MessengKefuClot_Text]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[MessengKefuClot_Text](
	[TypeID] [int] IDENTITY(1,1) NOT NULL,
	[Msg_ID] [nvarchar](255) NULL,
	[ClotID] [nvarchar](20) NULL,
	[PID] [int] NULL,
	[TypeName] [nvarchar](500) NULL,
	[Picture] [nvarchar](500) NULL,
	[MyID] [nvarchar](50) NULL,
	[YouID] [nvarchar](50) NULL,
	[FcName] [nvarchar](500) NULL,
	[To_Type] [smallint] NULL,
	[To_Date] [datetime] NULL,
	[To_Time] [datetime] NULL,
	[UserText] [nvarchar](max) NULL,
	[FontInfo] [nvarchar](50) NULL,
 CONSTRAINT [PK_MessengKefuClot_Text] PRIMARY KEY CLUSTERED 
(
	[TypeID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[MessengKefu_Type]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[MessengKefu_Type](
	[TypeID] [int] IDENTITY(1,1) NOT NULL,
	[UserID1] [nvarchar](20) NOT NULL,
	[UserID2] [nvarchar](20) NOT NULL,
	[FcName] [nvarchar](50) NULL,
	[UserText] [nvarchar](max) NULL,
	[TO_IP] [nvarchar](20) NULL,
	[TO_Date] [datetime] NULL,
	[To_Type] [int] NULL,
 CONSTRAINT [PK_MessengKefu_Type] PRIMARY KEY CLUSTERED 
(
	[TypeID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[MessengKefu_Text]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[MessengKefu_Text](
	[TypeID] [int] IDENTITY(1,1) NOT NULL,
	[Msg_ID] [nvarchar](255) NULL,
	[MyID] [nvarchar](50) NULL,
	[YouID] [nvarchar](50) NULL,
	[FcName] [nvarchar](500) NULL,
	[Picture] [nvarchar](500) NULL,
	[ChatId] [int] NULL,
	[To_Type] [smallint] NULL,
	[IsReceipt] [int] NULL,
	[To_Date] [datetime] NULL,
	[To_Time] [datetime] NULL,
	[UserText] [nvarchar](max) NULL,
	[FontInfo] [nvarchar](50) NULL,
	[IsReceipt1] [int] NULL,
	[IsReceipt2] [int] NULL,
	[IsAck1] [int] NULL,
	[IsAck2] [int] NULL,
	[IsAck3] [int] NULL,
	[IsAck4] [int] NULL,
	[IsAck5] [int] NULL,
	[IsAck6] [int] NULL,
	[IsAck7] [int] NULL,
	[IsAck8] [int] NULL,
 CONSTRAINT [PK_MessengKefu_Text] PRIMARY KEY CLUSTERED 
(
	[TypeID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[MessengClot_Type]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[MessengClot_Type](
	[TypeID] [int] IDENTITY(1,1) NOT NULL,
	[UserID1] [nvarchar](20) NOT NULL,
	[ClotID] [nvarchar](50) NULL,
	[UserID2] [nvarchar](20) NOT NULL,
	[UserText] [nvarchar](max) NULL,
	[TO_IP] [nvarchar](20) NULL,
	[TO_Date] [datetime] NULL,
	[To_Type] [int] NULL,
	[FontInfo] [nvarchar](50) NULL,
 CONSTRAINT [PK_MessengClot_Type] PRIMARY KEY CLUSTERED 
(
	[TypeID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[MessengClot_Text]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[MessengClot_Text](
	[TypeID] [int] IDENTITY(1,1) NOT NULL,
	[Msg_ID] [nvarchar](255) NULL,
	[ClotID] [nvarchar](20) NULL,
	[MyID] [nvarchar](20) NULL,
	[YouID] [nvarchar](20) NULL,
	[FcName] [nvarchar](20) NULL,
	[To_Type] [smallint] NULL,
	[To_Date] [datetime] NULL,
	[To_Time] [datetime] NULL,
	[UserText] [nvarchar](max) NULL,
	[FontInfo] [nvarchar](50) NULL,
 CONSTRAINT [PK_MessengClot_Text] PRIMARY KEY CLUSTERED 
(
	[TypeID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Messeng_Type]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Messeng_Type](
	[TypeID] [int] IDENTITY(1,1) NOT NULL,
	[UserID1] [nvarchar](20) NOT NULL,
	[UserID2] [nvarchar](20) NOT NULL,
	[UserText] [nvarchar](max) NULL,
	[TO_IP] [nvarchar](20) NULL,
	[TO_Date] [datetime] NULL,
	[To_Type] [int] NULL,
	[FontInfo] [nvarchar](50) NULL,
 CONSTRAINT [PK_Messeng_Type] PRIMARY KEY CLUSTERED 
(
	[TypeID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Messeng_Text]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Messeng_Text](
	[TypeID] [int] IDENTITY(1,1) NOT NULL,
	[Msg_ID] [nvarchar](255) NULL,
	[MyID] [nvarchar](20) NULL,
	[YouID] [nvarchar](20) NULL,
	[FcName] [nvarchar](20) NULL,
	[To_Type] [smallint] NULL,
	[IsReceipt] [bit] NULL,
	[To_Date] [datetime] NULL,
	[To_Time] [datetime] NULL,
	[UserText] [nvarchar](max) NULL,
	[FontInfo] [nvarchar](50) NULL,
	[IsReceipt1] [int] NULL,
	[IsReceipt2] [int] NULL,
	[IsAck1] [int] NULL,
	[IsAck2] [int] NULL,
	[IsAck3] [int] NULL,
	[IsAck4] [int] NULL,
	[IsAck5] [int] NULL,
	[IsAck6] [int] NULL,
	[IsAck7] [int] NULL,
	[IsAck8] [int] NULL,
 CONSTRAINT [PK_Messeng_Text] PRIMARY KEY CLUSTERED 
(
	[TypeID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[MD5File]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[MD5File](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[MyID] [nvarchar](10) NULL,
	[FormFileType] [smallint] NULL,
	[TypePath] [nvarchar](512) NULL,
	[PcSize] [nvarchar](50) NULL,
	[ToDate] [datetime] NULL,
	[ToTime] [datetime] NULL,
	[FilPath] [nvarchar](512) NULL,
	[MD5Hash] [nvarchar](200) NULL,
 CONSTRAINT [PK_MD5File] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[MD5BigFile]    Script Date: 10/29/2022 23:33:54 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[MD5BigFile](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[MyID] [nvarchar](10) NULL,
	[FormFileType] [smallint] NULL,
	[TypePath] [nvarchar](512) NULL,
	[PcSize] [nvarchar](50) NULL,
	[ToDate] [datetime] NULL,
	[ToTime] [datetime] NULL,
	[FilPath] [nvarchar](512) NULL,
	[BlobNum] [int] NULL,
	[Context] [nvarchar](200) NULL,
 CONSTRAINT [PK_BigFile] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[MD5VideoFile]    Script Date: 11/03/2022 15:13:32 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[MD5VideoFile](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[MyID] [nvarchar](10) NULL,
	[FormFileType] [smallint] NULL,
	[TypePath] [nvarchar](512) NULL,
	[PcSize] [nvarchar](50) NULL,
	[ToDate] [datetime] NULL,
	[ToTime] [datetime] NULL,
	[FilPath] [nvarchar](512) NULL,
	[Context] [nvarchar](200) NULL,
 CONSTRAINT [PK_MD5VideoFile] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[lv_user_ro]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[lv_user_ro](
	[TypeID] [int] IDENTITY(1,1) NOT NULL,
	[TypeName] [nvarchar](50) NULL,
	[Description] [nvarchar](500) NULL,
	[To_Type] [smallint] NULL,
	[Status] [int] NULL,
	[Ord] [int] NULL,
	[CreateTime] [datetime] NULL,
 CONSTRAINT [PK_lv_user_ro] PRIMARY KEY CLUSTERED 
(
	[TypeID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[lv_user_reception]    Script Date: 02/20/2023 10:47:50 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[lv_user_reception](
	[TypeID] [int] IDENTITY(1,1) NOT NULL,
	[MyID] [nvarchar](50) NOT NULL,
	[YouID] [nvarchar](50) NOT NULL,
	[Ncontent] [nvarchar](max) NULL,
	[TO_IP] [nvarchar](20) NULL,
	[TO_Date] [datetime] NULL,
	[To_Type] [int] NULL,
	[ChaterReception] [int] NULL,
	[Chater_RoReception] [int] NULL,
	[DefaultReception] [int] NULL,
 CONSTRAINT [PK_lv_user_reception] PRIMARY KEY CLUSTERED 
(
	[TypeID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[lv_user_form]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[lv_user_form](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[UserId] [nvarchar](50) NULL,
	[LoginName] [nvarchar](50) NULL,
	[UserName] [nvarchar](50) NULL,
	[TypeID] [int] NULL,
	[To_Type] [int] NULL,
	[MyID] [nvarchar](50) NULL,
 CONSTRAINT [PK_lv_user_form] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[lv_user]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[lv_user](
	[UserId] [nvarchar](50) NOT NULL,
	[UserName] [nvarchar](50) NULL,
	[Email] [nvarchar](50) NULL,
	[Phone] [nvarchar](50) NULL,
	[QQ] [nvarchar](50) NULL,
	[WeChat] [nvarchar](50) NULL,
	[Remarks] [nvarchar](500) NULL,
	[OtherTitle] [nvarchar](50) NULL,
	[OtherUrl] [nvarchar](500) NULL,
	[cookieHCID1] [nvarchar](50) NULL,
	[cookieHCID2] [nvarchar](50) NULL,
	[cookieHCID3] [nvarchar](50) NULL,
	[cookieHCID4] [nvarchar](50) NULL,
	[cookieHCID5] [int] NULL,
	[cookieHCID6] [int] NULL,
	[cookieHCID7] [int] NULL,
	[cookieHCID8] [int] NULL,
	[cookieHCID9] [nvarchar](500) NULL,
	[cookieHCID10] [nvarchar](500) NULL,
	[RegTime] [datetime] NOT NULL,
	[IP] [nvarchar](50) NULL,
	[Area] [nvarchar](50) NULL,
	[UserIcoLine] [tinyint] NULL,
	[Status] [int] NULL,
	[IsWeb] [tinyint] NULL,
	[ChatCount] [int] NULL,
	[LastTime] [datetime] NULL,
	[maxTypeID] [int] NULL,
	[myChater] [nvarchar](50) NULL,
	[Chater] [nvarchar](50) NULL,
	[LoginName] [nvarchar](50) NULL,
	[TypeID] [int] NULL,
	[IsWeiXin] [tinyint] NULL,
	[subscribe] [tinyint] NULL,
	[sex] [tinyint] NULL,
	[language] [nvarchar](50) NULL,
	[city] [nvarchar](50) NULL,
	[province] [nvarchar](50) NULL,
	[country] [nvarchar](50) NULL,
	[headimgurl] [nvarchar](500) NULL,
	[privilege] [nvarchar](500) NULL,
 CONSTRAINT [PK_lv_user] PRIMARY KEY CLUSTERED 
(
	[UserId] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[lv_transfer]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[lv_transfer](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[ChatId] [int] NULL,
	[MyID] [nvarchar](50) NULL,
	[YouID] [nvarchar](50) NULL,
	[Chater] [nvarchar](50) NULL,
	[To_Type] [int] NULL,
	[Todate] [datetime] NULL,
 CONSTRAINT [PK_lv_transfer] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[lv_track]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[lv_track](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[SourceId] [int] NULL,
	[ChatId] [nvarchar](50) NULL,
	[GroupId] [int] NULL,
	[Chater] [nvarchar](50) NULL,
	[UserId] [nvarchar](50) NULL,
	[UserName] [nvarchar](50) NULL,
	[TrackUrl] [nvarchar](500) NULL,
	[Flag] [int] NULL,
	[InTime] [datetime] NOT NULL,
	[Ord] [int] NULL,
 CONSTRAINT [PK_lv_track] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[lv_source]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[lv_source](
	[SourceId] [int] IDENTITY(1,1) NOT NULL,
	[ChatId] [nvarchar](50) NULL,
	[GroupId] [int] NULL,
	[Chater] [nvarchar](50) NULL,
	[UserId] [nvarchar](50) NULL,
	[UserName] [nvarchar](50) NULL,
	[SourceUrl] [nvarchar](500) NULL,
	[LaunchUrl] [nvarchar](500) NULL,
	[KeyWord] [nvarchar](255) NULL,
	[Flag] [int] NULL,
	[IP] [nvarchar](50) NULL,
	[Area] [nvarchar](50) NULL,
	[Browser] [nvarchar](500) NULL,
	[InTime] [datetime] NOT NULL,
	[Ord] [int] NULL,
 CONSTRAINT [PK_lv_source] PRIMARY KEY CLUSTERED 
(
	[SourceId] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[lv_quicktalk]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[lv_quicktalk](
	[TalkId] [int] NOT NULL,
	[Chater] [nvarchar](50) NULL,
	[Subject] [nvarchar](255) NULL,
	[UserText] [nvarchar](max) NULL,
	[To_Type] [smallint] NULL,
	[Status] [int] NULL,
	[Ord] [int] NULL,
	[CreateTime] [datetime] NOT NULL,
 CONSTRAINT [PK_lv_quick_talk] PRIMARY KEY CLUSTERED 
(
	[TalkId] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[lv_question]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[lv_question](
	[QuestionId] [int] NOT NULL,
	[Chater] [nvarchar](50) NULL,
	[Subject] [nvarchar](255) NULL,
	[UserText] [nvarchar](max) NULL,
	[To_Type] [smallint] NULL,
	[col_match] [smallint] NULL,
	[col_receive] [smallint] NULL,
	[col_top] [smallint] NULL,
	[Status] [int] NULL,
	[Ord] [int] NULL,
	[CreateTime] [datetime] NOT NULL,
 CONSTRAINT [PK_lv_question] PRIMARY KEY CLUSTERED 
(
	[QuestionId] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[lv_message]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[lv_message](
	[Id] [int] NOT NULL,
	[GroupId] [int] NULL,
	[Chater] [nvarchar](50) NULL,
	[UserId] [nvarchar](50) NULL,
	[UserName] [nvarchar](50) NULL,
	[Email] [nvarchar](50) NULL,
	[Phone] [nvarchar](50) NULL,
	[IP] [nvarchar](50) NULL,
	[UserText] [nvarchar](1024) NULL,
	[CreateTime] [datetime] NOT NULL,
 CONSTRAINT [PK_lv_message] PRIMARY KEY CLUSTERED 
(
	[Id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[lv_link]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[lv_link](
	[LinkId] [int] NOT NULL,
	[Chater] [nvarchar](50) NULL,
	[LinkName] [nvarchar](255) NULL,
	[LinkUrl] [nvarchar](255) NULL,
	[LinkType] [int] NULL,
	[Ord] [int] NULL,
	[CreateTime] [datetime] NOT NULL,
 CONSTRAINT [PK_lv_link] PRIMARY KEY CLUSTERED 
(
	[LinkId] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[lv_file]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[lv_file](
	[FileId] [int] NOT NULL,
	[ChatId] [nvarchar](50) NULL,
	[GroupId] [int] NULL,
	[Chater] [nvarchar](50) NULL,
	[UserName] [nvarchar](50) NULL,
	[FileName] [nvarchar](255) NULL,
	[FileSize] [int] NULL,
	[FilePath] [nvarchar](255) NULL,
	[Flag] [int] NULL,
	[CreateUser] [nvarchar](255) NULL,
	[CreateTime] [datetime] NOT NULL,
	[Ord] [int] NULL,
 CONSTRAINT [PK_lv_file] PRIMARY KEY CLUSTERED 
(
	[FileId] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[lv_chater_wechat]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[lv_chater_wechat](
	[TypeID] [int] IDENTITY(1,1) NOT NULL,
	[GroupId] [int] NULL,
	[TypeName] [nvarchar](50) NULL,
	[Description] [nvarchar](500) NULL,
	[domain] [nvarchar](200) NULL,
	[appid] [nvarchar](200) NULL,
	[sercet] [nvarchar](200) NULL,
	[token] [nvarchar](200) NULL,
	[moban_id] [nvarchar](200) NULL,
	[subscribe] [int] NULL,
	[subscribe_id] [nvarchar](200) NULL,
	[subscribe_id2] [nvarchar](200) NULL,
	[Description1] [nvarchar](500) NULL,
	[domain1] [nvarchar](200) NULL,
	[appid1] [nvarchar](200) NULL,
	[sercet1] [nvarchar](200) NULL,
	[moban_id1] [nvarchar](200) NULL,
	[customer_service_link] [nvarchar](500) NULL,
	[Status] [int] NULL,
	[Ord] [int] NULL,
	[CreateTime] [datetime] NULL,
 CONSTRAINT [PK_lv_chater_wechat] PRIMARY KEY CLUSTERED 
(
	[TypeID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[lv_chater_theme]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[lv_chater_theme](
	[TypeID] [int] IDENTITY(1,1) NOT NULL,
	[GroupId] [int] NULL,
	[TypeName] [nvarchar](50) NULL,
	[Description] [nvarchar](500) NULL,
	[Status] [int] NULL,
	[Ord] [int] NULL,
	[CreateTime] [datetime] NULL,
 CONSTRAINT [PK_lv_chater_theme] PRIMARY KEY CLUSTERED 
(
	[TypeID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[lv_chater_ro]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[lv_chater_ro](
	[TypeID] [int] IDENTITY(1,1) NOT NULL,
	[TypeName] [nvarchar](500) NULL,
	[Description] [nvarchar](500) NULL,
	[To_Type] [smallint] NULL,
	[Status] [int] NULL,
	[WelCome] [nvarchar](max) NULL,
	[DefaultReception] [int] NULL,
	[Ord] [int] NULL,
	[CreateTime] [datetime] NULL,
 CONSTRAINT [PK_lv_chater_ro] PRIMARY KEY CLUSTERED 
(
	[TypeID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[lv_chater_notice]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[lv_chater_notice](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[UserId] [nvarchar](50) NULL,
	[LoginName] [nvarchar](50) NULL,
	[UserName] [nvarchar](50) NULL,
	[TypeID] [int] NULL,
 CONSTRAINT [PK_lv_chater_notice] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[lv_chater_KefuMsg_Acks]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[lv_chater_KefuMsg_Acks](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[Msg_ID] [nvarchar](255) NULL,
	[ClotID] [nvarchar](20) NULL,
	[MyID] [nvarchar](20) NULL,
	[YouID] [nvarchar](20) NULL,
	[IsReceipt1] [int] NULL,
	[IsReceipt2] [int] NULL,
	[To_Date] [datetime] NULL,
	[To_Time] [datetime] NULL,
 CONSTRAINT [PK_KefuMsg_Acks] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[lv_chater_form]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[lv_chater_form](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[UserId] [nvarchar](50) NULL,
	[LoginName] [nvarchar](50) NULL,
	[UserName] [nvarchar](50) NULL,
	[TypeID] [int] NULL,
 CONSTRAINT [PK_lv_chater_form] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[lv_chater_domain]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[lv_chater_domain](
	[TypeID] [int] IDENTITY(1,1) NOT NULL,
	[GroupId] [int] NULL,
	[TypeName] [nvarchar](50) NULL,
	[Description] [nvarchar](500) NULL,
	[Status] [int] NULL,
	[Ord] [int] NULL,
	[CreateTime] [datetime] NULL,
 CONSTRAINT [PK_lv_chater_domain] PRIMARY KEY CLUSTERED 
(
	[TypeID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[lv_chater_Clot_Ro]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[lv_chater_Clot_Ro](
	[TypeID] [int] IDENTITY(1,1) NOT NULL,
	[PID] [int] NULL,
	[UserId] [nvarchar](50) NULL,
	[TypeName] [nvarchar](200) NULL,
	[Remark] [nvarchar](max) NULL,
	[IP] [nvarchar](50) NULL,
	[Area] [nvarchar](50) NULL,
	[To_Date] [datetime] NULL,
	[Sender] [int] NULL,
	[UserState] [int] NULL,
	[Disk_Space] [nvarchar](50) NULL,
	[IsPublic] [int] NULL,
	[OwnerID] [nvarchar](50) NULL,
	[ItemIndex] [nvarchar](50) NULL,
	[CreatorID] [nvarchar](50) NULL,
	[CreatorName] [nvarchar](200) NULL,
	[Users_IDVesr] [int] NULL,
	[Users_FormVesr] [int] NULL,
 CONSTRAINT [PK_lv_chater_Clot_Ro] PRIMARY KEY CLUSTERED 
(
	[TypeID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[lv_chater_Clot_Form]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[lv_chater_Clot_Form](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[PID] [int] NULL,
	[TypeID] [int] NOT NULL,
	[UserID] [nvarchar](50) NOT NULL,
	[IsAdmin] [tinyint] NULL,
	[remark] [nvarchar](255) NULL,
	[last_ack_typeid1] [int] NULL,
	[last_ack_typeid2] [int] NULL,
	[last_ack_typeid3] [int] NULL,
	[last_ack_typeid4] [int] NULL,
	[last_ack_typeid5] [int] NULL,
	[last_ack_typeid6] [int] NULL,
	[last_ack_typeid7] [int] NULL,
	[last_ack_typeid8] [int] NULL,
	[To_Date] [datetime] NULL,
 CONSTRAINT [PK_lv_chater_Clot_Form] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[lv_chater]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[lv_chater](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[UserId] [int] NOT NULL,
	[LoginName] [nvarchar](50) NULL,
	[UserName] [nvarchar](50) NULL,
	[DeptName] [nvarchar](50) NULL,
	[JobTitle] [nvarchar](50) NULL,
	[Email] [nvarchar](50) NULL,
	[Phone] [nvarchar](50) NULL,
	[Mobile] [nvarchar](50) NULL,
	[Picture] [nvarchar](100) NULL,
	[Status] [int] NULL,
	[WelCome] [nvarchar](max) NULL,
	[DefaultReception] [int] NULL,
	[DefaultTargetLanguage] [nvarchar](50) NULL,
	[UserAutoTranslate] [int] NULL,
	[UserTargetLanguage] [nvarchar](50) NULL,
	[ChaterAutoTranslate] [int] NULL,
	[ChaterTargetLanguage] [nvarchar](50) NULL,
	[Reception] [int] NULL,
	[FreeTime] [int] NULL,
	[EndSession] [int] NULL,
	[Ord] [int] NULL,
 CONSTRAINT [PK_lv_chater] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[lv_chat]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[lv_chat](
	[ChatId] [int] NOT NULL,
	[GroupId] [int] NULL,
	[Chater] [nvarchar](50) NULL,
	[UserId] [nvarchar](50) NULL,
	[UserName] [nvarchar](50) NULL,
	[IP] [nvarchar](50) NULL,
	[Area] [nvarchar](50) NULL,
	[InTime] [datetime] NULL,
	[ConnectTime] [datetime] NOT NULL,
	[OutTime] [datetime] NULL,
	[Status] [int] NULL,
	[CloseRole] [int] NULL,
	[Rate] [int] NULL,
	[RateNote] [nvarchar](500) NULL,
	[ThemeId] [int] NULL,
	[ChatLevel] [int] NULL,
	[IsEnable] [int] NULL,
	[AllowUploadFile] [int] NULL,
	[NContent] [nvarchar](500) NULL,
	[Ord] [int] NULL,
 CONSTRAINT [PK_lv_chat] PRIMARY KEY CLUSTERED 
(
	[ChatId] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[LeaveFile]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[LeaveFile](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[Msg_ID] [nvarchar](255) NULL,
	[UserID1] [nvarchar](10) NULL,
	[UserID2] [nvarchar](50) NULL,
	[TypePath] [nvarchar](512) NULL,
	[PcSize] [nvarchar](50) NULL,
	[ToDate] [datetime] NULL,
	[SendTy] [bit] NOT NULL,
	[FilPath] [nvarchar](512) NULL,
	[OnlineID] [int] NULL,
 CONSTRAINT [PK_LeaveFile] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[KefuConfig]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[KefuConfig](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[IPAddress] [nvarchar](50) NULL,
	[User_ID] [nvarchar](max) NULL,
	[WebCode] [nvarchar](max) NULL,
	[welcome] [nvarchar](200) NULL,
 CONSTRAINT [PK_KefuConfig] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Kefu]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Kefu](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[IP] [nvarchar](50) NULL,
	[City] [nvarchar](50) NULL,
 CONSTRAINT [PK_Kefu] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[jsdl2]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[jsdl2](
	[ID] [int] NULL,
	[Mobile] [nvarchar](15) NOT NULL,
	[Content] [nvarchar](255) NOT NULL,
	[Status] [int] NOT NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[jsdl]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[jsdl](
	[ID] [int] NOT NULL,
	[Mobile] [nvarchar](15) NOT NULL,
	[Content] [nvarchar](255) NOT NULL,
	[Recetime] [datetime] NOT NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[jod]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[jod](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[TypeName] [nvarchar](50) NULL,
 CONSTRAINT [PK_jod] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Heat_Form]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Heat_Form](
	[UserID] [nvarchar](20) NOT NULL,
	[Type] [int] NULL,
	[LoCoun] [nvarchar](5) NULL,
	[FcName] [nvarchar](50) NULL,
 CONSTRAINT [PK_Heat_Form] PRIMARY KEY CLUSTERED 
(
	[UserID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[FontForm1]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[FontForm1](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[FontName] [nvarchar](50) NULL,
	[FontSize] [int] NULL,
	[FontColro] [nvarchar](20) NULL,
	[Bold] [bit] NOT NULL,
	[Underline] [bit] NOT NULL,
	[Italic] [bit] NOT NULL,
 CONSTRAINT [PK_FontForm1] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[FontForm]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[FontForm](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[FontName] [nvarchar](50) NULL,
	[FontSize] [int] NULL,
	[FontColro] [nvarchar](20) NULL,
	[Bold] [bit] NOT NULL,
	[Underline] [bit] NOT NULL,
	[Italic] [bit] NOT NULL,
 CONSTRAINT [PK_FontForm] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Fav_Form]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Fav_Form](
	[UpperID] [nvarchar](20) NOT NULL,
	[UserID] [nvarchar](20) NOT NULL,
	[MyID] [nvarchar](50) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[DownLoad]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[DownLoad](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[MyID] [nvarchar](10) NULL,
	[TypePath] [nvarchar](512) NULL,
	[PcSize] [nvarchar](50) NULL,
	[UsName] [nvarchar](50) NULL,
	[UsID] [nvarchar](20) NULL,
	[TypeS] [int] NULL,
	[ToDate] [datetime] NULL,
	[ToTime] [datetime] NULL,
 CONSTRAINT [PK_DownLoad] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[dfsdl]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[dfsdl](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[Mobile] [nvarchar](15) NOT NULL,
	[NContent] [nvarchar](255) NOT NULL,
	[Deadtime] [datetime] NOT NULL,
	[Status] [int] NOT NULL,
	[msgid] [smallint] NULL,
	[ImUserID] [nvarchar](20) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Col_Ro]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Col_Ro](
	[TypeID] [int] IDENTITY(1,1) NOT NULL,
	[TypeName] [nvarchar](200) NULL,
	[ToDate] [datetime] NULL,
	[ToTime] [datetime] NULL,
	[MyID] [nvarchar](50) NULL,
 CONSTRAINT [PK_Col_Ro] PRIMARY KEY CLUSTERED 
(
	[TypeID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Col_Form]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Col_Form](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[UpperID] [int] NOT NULL,
	[Title] [nvarchar](255) NULL,
	[NContent] [nvarchar](max) NULL,
	[UsName] [nvarchar](50) NULL,
	[UsID] [nvarchar](20) NULL,
	[TypeS] [nvarchar](255) NULL,
	[ToDate] [datetime] NULL,
	[ToTime] [datetime] NULL,
	[MyID] [nvarchar](50) NULL,
 CONSTRAINT [PK_Col_Form] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[ClotFile]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ClotFile](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[Msg_ID] [nvarchar](255) NULL,
	[MyID] [nvarchar](10) NULL,
	[UsName] [nvarchar](50) NULL,
	[ClotID] [nvarchar](50) NULL,
	[TypePath] [nvarchar](512) NULL,
	[PcSize] [nvarchar](50) NULL,
	[ToDate] [datetime] NULL,
	[ToTime] [datetime] NULL,
	[FilPath] [nvarchar](512) NULL,
	[OnlineID] [int] NULL,
	[FileState] [int] NULL,
 CONSTRAINT [PK_ClotFile] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Clot_Silence]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Clot_Silence](
	[TypeID] [int] IDENTITY(1,1) NOT NULL,
	[MyID] [nvarchar](50) NOT NULL,
	[YouID] [nvarchar](50) NOT NULL,
	[Ncontent] [nvarchar](max) NULL,
	[TO_IP] [nvarchar](20) NULL,
	[TO_Date] [datetime] NULL,
	[To_Type] [int] NULL,
 CONSTRAINT [PK_Clot_Silence] PRIMARY KEY CLUSTERED 
(
	[TypeID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Clot_Ro]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Clot_Ro](
	[TypeID] [nvarchar](20) NOT NULL,
	[TypeName] [nvarchar](200) NULL,
	[Remark] [nvarchar](max) NULL,
	[To_Date] [datetime] NULL,
	[Sender] [int] NULL,
	[UserState] [int] NULL,
	[Disk_Space] [nvarchar](50) NULL,
	[IsPublic] [int] NULL,
	[OwnerID] [nvarchar](50) NULL,
	[ItemIndex] [nvarchar](50) NULL,
	[CreatorID] [nvarchar](50) NULL,
	[CreatorName] [nvarchar](200) NULL,
	[Users_IDVesr] [int] NULL,
	[Users_FormVesr] [int] NULL,
 CONSTRAINT [PK_Clot_Ro] PRIMARY KEY CLUSTERED 
(
	[TypeID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Clot_Pic]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Clot_Pic](
	[ClotID] [nvarchar](20) NOT NULL,
	[ClotInfo] [int] NULL,
	[pic] [int] NULL,
	[Sfile] [int] NULL,
 CONSTRAINT [PK_Clot_Pic] PRIMARY KEY CLUSTERED 
(
	[ClotID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Clot_Form]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Clot_Form](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[UpperID] [nvarchar](20) NOT NULL,
	[UserID] [nvarchar](20) NOT NULL,
	[IsAdmin] [tinyint] NULL,
	[remark] [nvarchar](255) NULL,
	[last_ack_typeid1] [int] NULL,
	[last_ack_typeid2] [int] NULL,
	[last_ack_typeid3] [int] NULL,
	[last_ack_typeid4] [int] NULL,
	[last_ack_typeid5] [int] NULL,
	[last_ack_typeid6] [int] NULL,
	[last_ack_typeid7] [int] NULL,
	[last_ack_typeid8] [int] NULL,
 CONSTRAINT [PK_Clot_Form] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Board_Visiter]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Board_Visiter](
	[Col_ID] [int] IDENTITY(1,1) NOT NULL,
	[col_BoardID] [nvarchar](50) NULL,
	[Col_HsItem] [nvarchar](50) NULL,
	[Col_HsItem_Name] [nvarchar](50) NULL,
	[col_dt_Create] [datetime] NULL,
	[col_Readed] [int] NULL,
	[col_Dt_Readed] [datetime] NULL,
	[Col_HsItem_ID] [int] NULL,
 CONSTRAINT [PK_Board_Visiter] PRIMARY KEY CLUSTERED 
(
	[Col_ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Board_Revert]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Board_Revert](
	[Col_ID] [int] IDENTITY(1,1) NOT NULL,
	[Col_BoardID] [nvarchar](50) NULL,
	[Col_Content] [nvarchar](max) NULL,
	[Col_Creator_Id] [int] NOT NULL,
	[Col_Creator_Name] [nvarchar](50) NULL,
	[Col_Creator] [nvarchar](50) NULL,
	[Col_Expression] [nvarchar](200) NULL,
	[Col_Dt_Create] [datetime] NOT NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Board_Catalog]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Board_Catalog](
	[col_ID] [int] IDENTITY(1,1) NOT NULL,
	[Col_Name] [nvarchar](50) NULL,
	[col_Desc] [nvarchar](max) NULL,
	[col_Order] [int] NULL,
	[col_CompanyId] [int] NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Board_Attach]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Board_Attach](
	[col_ID] [int] IDENTITY(1,1) NOT NULL,
	[Col_BoardID] [nvarchar](50) NULL,
	[col_FileSize] [int] NULL,
	[col_FilePath] [nvarchar](255) NULL,
	[col_FileName] [nvarchar](255) NULL,
	[col_Dt_Create] [datetime] NULL,
	[col_Dt_Modify] [datetime] NULL,
 CONSTRAINT [PK_Board_Attach] PRIMARY KEY CLUSTERED 
(
	[col_ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Board]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Board](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[Col_ID] [nvarchar](50) NULL,
	[col_Creator_ID] [int] NULL,
	[col_Creator_Name] [nvarchar](50) NULL,
	[col_Modifyer_ID] [int] NULL,
	[col_Dt_Modify] [datetime] NULL,
	[col_Subject] [nvarchar](200) NULL,
	[Col_Content] [nvarchar](max) NULL,
	[Col_AttachmentCount] [int] NULL,
	[Col_ClickCount] [int] NULL,
	[col_Dt_Create] [datetime] NULL,
	[col_Order] [int] NULL,
	[col_G_ClassID] [int] NULL,
	[col_G_ObjID] [int] NULL,
	[col_IsPublic] [int] NULL,
	[col_Creator] [nvarchar](64) NULL,
	[Col_SenderIP] [nvarchar](50) NULL,
	[Col_SenderMAC] [nvarchar](50) NULL,
	[Col_ContentType] [nvarchar](50) NULL,
	[Col_DataPath] [nvarchar](max) NULL,
	[Col_CompanyId] [int] NULL,
	[Col_Creator_Dept] [nvarchar](100) NULL,
	[Col_Creator_DeptId] [int] NULL,
 CONSTRAINT [PK_Board] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[AdminGrant]    Script Date: 05/07/2022 10:23:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[AdminGrant](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[UserID] [nvarchar](50) NULL,
	[FcName] [nvarchar](200) NULL,
	[UppeID] [nvarchar](200) NULL,
	[DeptName] [nvarchar](max) NULL,
	[CountUser] [int] NULL,
	[CreatorID] [nvarchar](50) NULL,
	[CreatorName] [nvarchar](200) NULL,
	[CreateTime] [datetime] NULL,
	[Status] [int] NULL,
 CONSTRAINT [PK_Grant] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Default [DF_yfsdl_Id]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[yfsdl] ADD  CONSTRAINT [DF_yfsdl_Id]  DEFAULT ((0)) FOR [Id]
GO
/****** Object:  Default [DF_Users_WinInfo_UserIcoLine]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Users_WinInfo] ADD  CONSTRAINT [DF_Users_WinInfo_UserIcoLine]  DEFAULT ((0)) FOR [UserIcoLine]
GO
/****** Object:  Default [DF_Users_Role_RoleID]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Users_Role] ADD  CONSTRAINT [DF_Users_Role_RoleID]  DEFAULT ((0)) FOR [RoleID]
GO
/****** Object:  Default [DF_Users_Ro_ParentID]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Users_Ro] ADD  CONSTRAINT [DF_Users_Ro_ParentID]  DEFAULT ((0)) FOR [ParentID]
GO
/****** Object:  Default [DF_Users_Ro_ItemIndex]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Users_Ro] ADD  CONSTRAINT [DF_Users_Ro_ItemIndex]  DEFAULT ((0)) FOR [ItemIndex]
GO
/****** Object:  Default [DF_Users_Ro_CreatorID]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Users_Ro] ADD  CONSTRAINT [DF_Users_Ro_CreatorID]  DEFAULT ((1)) FOR [CreatorID]
GO
/****** Object:  Default [DF_Users_Ro_CreatorName]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Users_Ro] ADD  CONSTRAINT [DF_Users_Ro_CreatorName]  DEFAULT ('admin') FOR [CreatorName]
GO
/****** Object:  Default [DF_Users_Pic_pic]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Users_Pic] ADD  CONSTRAINT [DF_Users_Pic_pic]  DEFAULT ((0)) FOR [pic]
GO
/****** Object:  Default [DF_Users_Pic_file]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Users_Pic] ADD  CONSTRAINT [DF_Users_Pic_file]  DEFAULT ((0)) FOR [Sfile]
GO
/****** Object:  Default [DF_Users_ID_UserIco]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Users_ID] ADD  CONSTRAINT [DF_Users_ID_UserIco]  DEFAULT ((0)) FOR [UserIco]
GO
/****** Object:  Default [DF_Users_ID_UserIcoLine]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Users_ID] ADD  CONSTRAINT [DF_Users_ID_UserIcoLine]  DEFAULT ((0)) FOR [UserIcoLine]
GO
/****** Object:  Default [DF_Users_ID_Sequence]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Users_ID] ADD  CONSTRAINT [DF_Users_ID_Sequence]  DEFAULT ((0)) FOR [Sequence]
GO
/****** Object:  Default [DF_Users_ID_binding]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Users_ID] ADD  CONSTRAINT [DF_Users_ID_binding]  DEFAULT ((1)) FOR [binding]
GO
/****** Object:  Default [DF_Users_ID_UserState]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Users_ID] ADD  CONSTRAINT [DF_Users_ID_UserState]  DEFAULT ((1)) FOR [UserState]
GO
/****** Object:  Default [DF_Users_ID_IsVerify]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Users_ID] ADD  CONSTRAINT [DF_Users_ID_IsVerify]  DEFAULT ((1)) FOR [IsVerify]
GO
/****** Object:  Default [DF_Users_ID_IsManager]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Users_ID] ADD  CONSTRAINT [DF_Users_ID_IsManager]  DEFAULT ((0)) FOR [IsManager]
GO
/****** Object:  Default [DF_Users_ID_Fav_FormVesr]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Users_ID] ADD  CONSTRAINT [DF_Users_ID_Fav_FormVesr]  DEFAULT ((0)) FOR [Fav_FormVesr]
GO
/****** Object:  Default [DF_Users_ID_Col_FormVesr]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Users_ID] ADD  CONSTRAINT [DF_Users_ID_Col_FormVesr]  DEFAULT ((0)) FOR [Col_FormVesr]
GO
/****** Object:  Default [DF_Users_ID_Users_IDVesr]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Users_ID] ADD  CONSTRAINT [DF_Users_ID_Users_IDVesr]  DEFAULT ((0)) FOR [Users_IDVesr]
GO
/****** Object:  Default [DF_Users_ID_CreatorID]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Users_ID] ADD  CONSTRAINT [DF_Users_ID_CreatorID]  DEFAULT ((1)) FOR [CreatorID]
GO
/****** Object:  Default [DF_Users_ID_CreatorName]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Users_ID] ADD  CONSTRAINT [DF_Users_ID_CreatorName]  DEFAULT ('admin') FOR [CreatorName]
GO
/****** Object:  Default [DF_Users_ID_ExpireTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Users_ID] ADD  CONSTRAINT [DF_Users_ID_ExpireTime]  DEFAULT ((0)) FOR [ExpireTime]
GO
/****** Object:  Default [DF_UpDateForm_Users_RoVesr]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[UpDateForm] ADD  CONSTRAINT [DF_UpDateForm_Users_RoVesr]  DEFAULT ((0)) FOR [Users_RoVesr]
GO
/****** Object:  Default [DF_UpDateForm_Users_IDVesr]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[UpDateForm] ADD  CONSTRAINT [DF_UpDateForm_Users_IDVesr]  DEFAULT ((0)) FOR [Users_IDVesr]
GO
/****** Object:  Default [DF_UpDateForm_Clot_RoVesr]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[UpDateForm] ADD  CONSTRAINT [DF_UpDateForm_Clot_RoVesr]  DEFAULT ((0)) FOR [Clot_RoVesr]
GO
/****** Object:  Default [DF_UpDateForm_Clot_FormVesr]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[UpDateForm] ADD  CONSTRAINT [DF_UpDateForm_Clot_FormVesr]  DEFAULT ((0)) FOR [Clot_FormVesr]
GO
/****** Object:  Default [DF_UpDateForm_ClotFile_Vesr]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[UpDateForm] ADD  CONSTRAINT [DF_UpDateForm_ClotFile_Vesr]  DEFAULT ((0)) FOR [ClotFile_Vesr]
GO
/****** Object:  Default [DF_UpDateForm_SecInfoVesr]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[UpDateForm] ADD  CONSTRAINT [DF_UpDateForm_SecInfoVesr]  DEFAULT ((0)) FOR [SecInfoVesr]
GO
/****** Object:  Default [DF_UpDateForm_Tel_FormVesr]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[UpDateForm] ADD  CONSTRAINT [DF_UpDateForm_Tel_FormVesr]  DEFAULT ((0)) FOR [Tel_FormVesr]
GO
/****** Object:  Default [DF_UpDateForm_PtpFile_Vesr]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[UpDateForm] ADD  CONSTRAINT [DF_UpDateForm_PtpFile_Vesr]  DEFAULT ((0)) FOR [PtpFile_Vesr]
GO
/****** Object:  Default [DF_UpDateForm_PtpFolder_Vesr]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[UpDateForm] ADD  CONSTRAINT [DF_UpDateForm_PtpFolder_Vesr]  DEFAULT ((0)) FOR [PtpFolder_Vesr]
GO
/****** Object:  Default [DF_UpDateForm_PtpForm_Vesr]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[UpDateForm] ADD  CONSTRAINT [DF_UpDateForm_PtpForm_Vesr]  DEFAULT ((0)) FOR [PtpForm_Vesr]
GO
/****** Object:  Default [DF_UpDateForm_LeaveFile_Vesr]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[UpDateForm] ADD  CONSTRAINT [DF_UpDateForm_LeaveFile_Vesr]  DEFAULT ((0)) FOR [LeaveFile_Vesr]
GO
/****** Object:  Default [DF_UpDateForm_NewGo_Vesr]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[UpDateForm] ADD  CONSTRAINT [DF_UpDateForm_NewGo_Vesr]  DEFAULT ((0)) FOR [NewGo_Vesr]
GO
/****** Object:  Default [DF_UpDateForm_NewRo_Vesr]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[UpDateForm] ADD  CONSTRAINT [DF_UpDateForm_NewRo_Vesr]  DEFAULT ((0)) FOR [NewRo_Vesr]
GO
/****** Object:  Default [DF_UpDateForm_MyTel_RoVesr]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[UpDateForm] ADD  CONSTRAINT [DF_UpDateForm_MyTel_RoVesr]  DEFAULT ((0)) FOR [MyTel_RoVesr]
GO
/****** Object:  Default [DF_UpDateForm_MyTel_FormVesr]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[UpDateForm] ADD  CONSTRAINT [DF_UpDateForm_MyTel_FormVesr]  DEFAULT ((0)) FOR [MyTel_FormVesr]
GO
/****** Object:  Default [DF_UpDateForm_Plug_Vesr]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[UpDateForm] ADD  CONSTRAINT [DF_UpDateForm_Plug_Vesr]  DEFAULT ((0)) FOR [Plug_Vesr]
GO
/****** Object:  Default [DF_ToInfo_TO_Date]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[ToInfo] ADD  CONSTRAINT [DF_ToInfo_TO_Date]  DEFAULT (getdate()) FOR [TO_Date]
GO
/****** Object:  Default [DF_ToInfo_To_Time]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[ToInfo] ADD  CONSTRAINT [DF_ToInfo_To_Time]  DEFAULT (getdate()) FOR [To_Time]
GO
/****** Object:  Default [DF_Tel_Form_TelIco]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tel_Form] ADD  CONSTRAINT [DF_Tel_Form_TelIco]  DEFAULT ((1)) FOR [TelIco]
GO
/****** Object:  Default [DF_Tab_Meet_Msg_XXX_Col_SendLogin]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet_Msg_XXX] ADD  CONSTRAINT [DF_Tab_Meet_Msg_XXX_Col_SendLogin]  DEFAULT ('') FOR [Col_SendLogin]
GO
/****** Object:  Default [DF_Tab_Meet_Msg_XXX_Col_SendName]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet_Msg_XXX] ADD  CONSTRAINT [DF_Tab_Meet_Msg_XXX_Col_SendName]  DEFAULT ('') FOR [Col_SendName]
GO
/****** Object:  Default [DF_Tab_Meet_Msg_XXX_Col_Date]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet_Msg_XXX] ADD  CONSTRAINT [DF_Tab_Meet_Msg_XXX_Col_Date]  DEFAULT (getdate()) FOR [Col_Date]
GO
/****** Object:  Default [DF_Tab_Meet_Msg_XXX_Col_Content]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet_Msg_XXX] ADD  CONSTRAINT [DF_Tab_Meet_Msg_XXX_Col_Content]  DEFAULT ('') FOR [Col_Content]
GO
/****** Object:  Default [DF_Tab_Meet_Msg_XXX_Col_ContentType]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet_Msg_XXX] ADD  CONSTRAINT [DF_Tab_Meet_Msg_XXX_Col_ContentType]  DEFAULT ('') FOR [Col_ContentType]
GO
/****** Object:  Default [DF_Tab_Meet_Msg_XXX_Col_DataPath]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet_Msg_XXX] ADD  CONSTRAINT [DF_Tab_Meet_Msg_XXX_Col_DataPath]  DEFAULT ('') FOR [Col_DataPath]
GO
/****** Object:  Default [DF_Tab_Meet_Member_Col_UserLogin]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet_Member] ADD  CONSTRAINT [DF_Tab_Meet_Member_Col_UserLogin]  DEFAULT ('') FOR [Col_UserLogin]
GO
/****** Object:  Default [DF_Tab_Meet_Member_Col_UserName]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet_Member] ADD  CONSTRAINT [DF_Tab_Meet_Member_Col_UserName]  DEFAULT ('') FOR [Col_UserName]
GO
/****** Object:  Default [DF_Tab_Meet_Member_Col_UserID]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet_Member] ADD  CONSTRAINT [DF_Tab_Meet_Member_Col_UserID]  DEFAULT ((0)) FOR [Col_UserID]
GO
/****** Object:  Default [DF_Tab_Meet_Member_Col_JoinState]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet_Member] ADD  CONSTRAINT [DF_Tab_Meet_Member_Col_JoinState]  DEFAULT ((0)) FOR [Col_JoinState]
GO
/****** Object:  Default [DF_Tab_Meet_Member_Col_JoinTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet_Member] ADD  CONSTRAINT [DF_Tab_Meet_Member_Col_JoinTime]  DEFAULT ('1900-01-01 00:00:00') FOR [Col_JoinTime]
GO
/****** Object:  Default [DF_Tab_Meet_Member_Col_IsAdmin]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet_Member] ADD  CONSTRAINT [DF_Tab_Meet_Member_Col_IsAdmin]  DEFAULT ((0)) FOR [Col_IsAdmin]
GO
/****** Object:  Default [DF_Tab_Meet_Member_Col_LastMsgTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet_Member] ADD  CONSTRAINT [DF_Tab_Meet_Member_Col_LastMsgTime]  DEFAULT ('1900-01-01 00:00:00') FOR [Col_LastMsgTime]
GO
/****** Object:  Default [DF_Tab_Meet_Member_Col_LoginType]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet_Member] ADD  CONSTRAINT [DF_Tab_Meet_Member_Col_LoginType]  DEFAULT ((1)) FOR [Col_LoginType]
GO
/****** Object:  Default [DF_Tab_Meet_Member_Col_IsAudio]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet_Member] ADD  CONSTRAINT [DF_Tab_Meet_Member_Col_IsAudio]  DEFAULT ((0)) FOR [Col_IsAudio]
GO
/****** Object:  Default [DF_Tab_Meet_Member_Col_IsVideo]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet_Member] ADD  CONSTRAINT [DF_Tab_Meet_Member_Col_IsVideo]  DEFAULT ((0)) FOR [Col_IsVideo]
GO
/****** Object:  Default [DF_Tab_Meet_Member_Col_State]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet_Member] ADD  CONSTRAINT [DF_Tab_Meet_Member_Col_State]  DEFAULT ((0)) FOR [Col_State]
GO
/****** Object:  Default [DF_Tab_Meet_File_Col_FileName]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet_File] ADD  CONSTRAINT [DF_Tab_Meet_File_Col_FileName]  DEFAULT ('') FOR [Col_FileName]
GO
/****** Object:  Default [DF_Tab_Meet_File_Col_FileSize]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet_File] ADD  CONSTRAINT [DF_Tab_Meet_File_Col_FileSize]  DEFAULT ((0)) FOR [Col_FileSize]
GO
/****** Object:  Default [DF_Tab_Meet_File_Col_FileSName]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet_File] ADD  CONSTRAINT [DF_Tab_Meet_File_Col_FileSName]  DEFAULT ('') FOR [Col_FileSName]
GO
/****** Object:  Default [DF_Tab_Meet_File_Col_FileType]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet_File] ADD  CONSTRAINT [DF_Tab_Meet_File_Col_FileType]  DEFAULT ((0)) FOR [Col_FileType]
GO
/****** Object:  Default [DF_Tab_Meet_File_Col_SendLogin]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet_File] ADD  CONSTRAINT [DF_Tab_Meet_File_Col_SendLogin]  DEFAULT ('') FOR [Col_SendLogin]
GO
/****** Object:  Default [DF_Tab_Meet_File_Col_SendName]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet_File] ADD  CONSTRAINT [DF_Tab_Meet_File_Col_SendName]  DEFAULT ('') FOR [Col_SendName]
GO
/****** Object:  Default [DF_Tab_Meet_File_Col_SendDate]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet_File] ADD  CONSTRAINT [DF_Tab_Meet_File_Col_SendDate]  DEFAULT (getdate()) FOR [Col_SendDate]
GO
/****** Object:  Default [DF_Tab_Meet_File_Col_DownCount]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet_File] ADD  CONSTRAINT [DF_Tab_Meet_File_Col_DownCount]  DEFAULT ((0)) FOR [Col_DownCount]
GO
/****** Object:  Default [DF_Tab_Meet_File_Col_Group]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet_File] ADD  CONSTRAINT [DF_Tab_Meet_File_Col_Group]  DEFAULT ('') FOR [Col_Group]
GO
/****** Object:  Default [DF_Tab_Meet_Col_Name]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_Name]  DEFAULT ('') FOR [Col_Name]
GO
/****** Object:  Default [DF_Tab_Meet_Col_Desc]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_Desc]  DEFAULT ('') FOR [Col_Desc]
GO
/****** Object:  Default [DF_Tab_Meet_Col_Notice]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_Notice]  DEFAULT ('') FOR [Col_Notice]
GO
/****** Object:  Default [DF_Tab_Meet_Col_CreateLogin]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_CreateLogin]  DEFAULT ('') FOR [Col_CreateLogin]
GO
/****** Object:  Default [DF_Tab_Meet_Col_CreateName]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_CreateName]  DEFAULT ('') FOR [Col_CreateName]
GO
/****** Object:  Default [DF_Tab_Meet_Col_CreateID]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_CreateID]  DEFAULT ((0)) FOR [Col_CreateID]
GO
/****** Object:  Default [DF_Tab_Meet_Col_CreateDate]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_CreateDate]  DEFAULT (getdate()) FOR [Col_CreateDate]
GO
/****** Object:  Default [DF_Tab_Meet_Col_IsDelete]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_IsDelete]  DEFAULT ((0)) FOR [Col_IsDelete]
GO
/****** Object:  Default [DF_Tab_Meet_Col_Type]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_Type]  DEFAULT ((0)) FOR [Col_Type]
GO
/****** Object:  Default [DF_Tab_Meet_Col_JoinVerify]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_JoinVerify]  DEFAULT ((0)) FOR [Col_JoinVerify]
GO
/****** Object:  Default [DF_Tab_Meet_Col_Genre]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_Genre]  DEFAULT ('') FOR [Col_Genre]
GO
/****** Object:  Default [DF_Tab_Meet_Col_UserCount]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_UserCount]  DEFAULT ((200)) FOR [Col_UserCount]
GO
/****** Object:  Default [DF_Tab_Meet_Col_MsgIndex]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_MsgIndex]  DEFAULT ((0)) FOR [Col_MsgIndex]
GO
/****** Object:  Default [DF_Tab_Meet_Col_DomainID]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_DomainID]  DEFAULT ('') FOR [Col_DomainID]
GO
/****** Object:  Default [DF_Tab_Meet_Col_IsAudio]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_IsAudio]  DEFAULT ((0)) FOR [Col_IsAudio]
GO
/****** Object:  Default [DF_Tab_Meet_Col_IsVideo]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_IsVideo]  DEFAULT ((0)) FOR [Col_IsVideo]
GO
/****** Object:  Default [DF_Tab_Meet_Col_State]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_State]  DEFAULT ((0)) FOR [Col_State]
GO
/****** Object:  Default [DF_Tab_Meet_Col_SchDate]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_SchDate]  DEFAULT ('1900-01-01 00:00:00') FOR [Col_SchDate]
GO
/****** Object:  Default [DF_Tab_Config_Col_Name]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Config] ADD  CONSTRAINT [DF_Tab_Config_Col_Name]  DEFAULT ('') FOR [Col_Name]
GO
/****** Object:  Default [DF_Tab_Config_Col_Data]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Config] ADD  CONSTRAINT [DF_Tab_Config_Col_Data]  DEFAULT ('') FOR [Col_Data]
GO
/****** Object:  Default [DF_Tab_Config_Col_Genre]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Config] ADD  CONSTRAINT [DF_Tab_Config_Col_Genre]  DEFAULT ('') FOR [Col_Genre]
GO
/****** Object:  Default [DF_Tab_Config_col_AntServer]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Config] ADD  CONSTRAINT [DF_Tab_Config_col_AntServer]  DEFAULT ('') FOR [col_AntServer]
GO
/****** Object:  Default [DF_Tab_Config_col_LoginName]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Config] ADD  CONSTRAINT [DF_Tab_Config_col_LoginName]  DEFAULT ('') FOR [col_LoginName]
GO
/****** Object:  Default [DF_Tab_Config_col_HsItemID]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Config] ADD  CONSTRAINT [DF_Tab_Config_col_HsItemID]  DEFAULT ((0)) FOR [col_HsItemID]
GO
/****** Object:  Default [DF_Tab_Config_col_HsItemType]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Config] ADD  CONSTRAINT [DF_Tab_Config_col_HsItemType]  DEFAULT ((0)) FOR [col_HsItemType]
GO
/****** Object:  Default [DF_Tab_Config_col_PackageName]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Config] ADD  CONSTRAINT [DF_Tab_Config_col_PackageName]  DEFAULT ('') FOR [Col_PackageName]
GO
/****** Object:  Default [DF_Tab_Config_col_Disable]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Config] ADD  CONSTRAINT [DF_Tab_Config_col_Disable]  DEFAULT ((0)) FOR [Col_Disabled]
GO
/****** Object:  Default [DF_Tab_Chat_GroupId]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_GroupId]  DEFAULT ((0)) FOR [GroupId]
GO
/****** Object:  Default [DF_Tab_Chat_UserId]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_UserId]  DEFAULT ((0)) FOR [YouID]
GO
/****** Object:  Default [DF_Tab_Chat_ConnectTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_ConnectTime]  DEFAULT (getdate()) FOR [ConnectTime]
GO
/****** Object:  Default [DF_Tab_Chat_Col_IsAudio]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_Col_IsAudio]  DEFAULT ((0)) FOR [IsAudio]
GO
/****** Object:  Default [DF_Tab_Chat_Col_IsVideo]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_Col_IsVideo]  DEFAULT ((0)) FOR [IsVideo]
GO
/****** Object:  Default [DF_Tab_Chat_LoginType]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_LoginType]  DEFAULT ((1)) FOR [LoginType1]
GO
/****** Object:  Default [DF_Tab_Chat_LoginType2]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_LoginType2]  DEFAULT ((1)) FOR [LoginType2]
GO
/****** Object:  Default [DF_Tab_Chat_IsAudio1]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_IsAudio1]  DEFAULT ((0)) FOR [IsAudio1]
GO
/****** Object:  Default [DF_Tab_Chat_IsVideo1]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_IsVideo1]  DEFAULT ((0)) FOR [IsVideo1]
GO
/****** Object:  Default [DF_Tab_Chat_IsAudio2]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_IsAudio2]  DEFAULT ((0)) FOR [IsAudio2]
GO
/****** Object:  Default [DF_Tab_Chat_IsVideo2]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_IsVideo2]  DEFAULT ((0)) FOR [IsVideo2]
GO
/****** Object:  Default [DF_Tab_Chat_Status]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_Status]  DEFAULT ((0)) FOR [Status]
GO
/****** Object:  Default [DF_Tab_Chat_CloseRole]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_CloseRole]  DEFAULT ((0)) FOR [CloseRole]
GO
/****** Object:  Default [DF_Tab_Chat_Rate]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_Rate]  DEFAULT ((0)) FOR [Rate]
GO
/****** Object:  Default [DF_Tab_Chat_AllowUploadFile]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_AllowUploadFile]  DEFAULT ((0)) FOR [AllowUploadFile]
GO
/****** Object:  Default [DF_Tab_Chat_Ord]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_Ord]  DEFAULT ((0)) FOR [Ord]
GO
/****** Object:  Default [DF_ServerLog_Todate]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[ServerLog] ADD  CONSTRAINT [DF_ServerLog_Todate]  DEFAULT (getdate()) FOR [Todate]
GO
/****** Object:  Default [DF_ServerLog_Ico]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[ServerLog] ADD  CONSTRAINT [DF_ServerLog_Ico]  DEFAULT ((1)) FOR [Ico]
GO
/****** Object:  Default [DF_ServerLog_To_Type]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[ServerLog] ADD  CONSTRAINT [DF_ServerLog_To_Type]  DEFAULT ((1)) FOR [To_Type]
GO
/****** Object:  Default [DF_ANT_SMS_ADDRESS_col_name]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[rtc_sms_address] ADD  CONSTRAINT [DF_ANT_SMS_ADDRESS_col_name]  DEFAULT ('') FOR [col_name]
GO
/****** Object:  Default [DF_ANT_SMS_ADDRESS_col_mobile]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[rtc_sms_address] ADD  CONSTRAINT [DF_ANT_SMS_ADDRESS_col_mobile]  DEFAULT ('') FOR [col_mobile]
GO
/****** Object:  Default [DF_ANT_SMS_ADDRESS_col_owner]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[rtc_sms_address] ADD  CONSTRAINT [DF_ANT_SMS_ADDRESS_col_owner]  DEFAULT ('') FOR [col_owner]
GO
/****** Object:  Default [DF_Ant_sms_account_Col_account]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[rtc_sms_account] ADD  CONSTRAINT [DF_Ant_sms_account_Col_account]  DEFAULT ('') FOR [Col_account]
GO
/****** Object:  Default [DF_Ant_sms_account_Col_password]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[rtc_sms_account] ADD  CONSTRAINT [DF_Ant_sms_account_Col_password]  DEFAULT ('') FOR [Col_password]
GO
/****** Object:  Default [DF_Ant_sms_account_Col_emp_type]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[rtc_sms_account] ADD  CONSTRAINT [DF_Ant_sms_account_Col_emp_type]  DEFAULT ((0)) FOR [Col_emp_type]
GO
/****** Object:  Default [DF_Ant_sms_account_Col_emp_id]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[rtc_sms_account] ADD  CONSTRAINT [DF_Ant_sms_account_Col_emp_id]  DEFAULT ((0)) FOR [Col_emp_id]
GO
/****** Object:  Default [DF_Ant_sms_account_Col_emp_name]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[rtc_sms_account] ADD  CONSTRAINT [DF_Ant_sms_account_Col_emp_name]  DEFAULT ('') FOR [Col_emp_name]
GO
/****** Object:  Default [DF_Ant_sms_account_Col_Creator_id]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[rtc_sms_account] ADD  CONSTRAINT [DF_Ant_sms_account_Col_Creator_id]  DEFAULT ((0)) FOR [Col_Creator_ID]
GO
/****** Object:  Default [DF_Ant_sms_account_Col_Creator_Name]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[rtc_sms_account] ADD  CONSTRAINT [DF_Ant_sms_account_Col_Creator_Name]  DEFAULT ('') FOR [Col_Creator_Name]
GO
/****** Object:  Default [DF_Ant_sms_account_Col_Dt_Create]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[rtc_sms_account] ADD  CONSTRAINT [DF_Ant_sms_account_Col_Dt_Create]  DEFAULT (getdate()) FOR [Col_Dt_Create]
GO
/****** Object:  Default [DF_Ant_SMS_col_content]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[rtc_sms] ADD  CONSTRAINT [DF_Ant_SMS_col_content]  DEFAULT ('') FOR [col_content]
GO
/****** Object:  Default [DF_Ant_SMS_col_recv_mobile]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[rtc_sms] ADD  CONSTRAINT [DF_Ant_SMS_col_recv_mobile]  DEFAULT ('') FOR [col_recv_mobile]
GO
/****** Object:  Default [DF_Ant_SMS_col_recv_name]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[rtc_sms] ADD  CONSTRAINT [DF_Ant_SMS_col_recv_name]  DEFAULT ('') FOR [col_recv_name]
GO
/****** Object:  Default [DF_Ant_SMS_col_send_name]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[rtc_sms] ADD  CONSTRAINT [DF_Ant_SMS_col_send_name]  DEFAULT ('') FOR [col_send_name]
GO
/****** Object:  Default [DF_Ant_SMS_col_send_time]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[rtc_sms] ADD  CONSTRAINT [DF_Ant_SMS_col_send_time]  DEFAULT ('') FOR [col_send_time]
GO
/****** Object:  Default [DF_Ant_SMS_col_send_url]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[rtc_sms] ADD  CONSTRAINT [DF_Ant_SMS_col_send_url]  DEFAULT ('') FOR [col_send_url]
GO
/****** Object:  Default [DF_Ant_SMS_col_creator_id]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[rtc_sms] ADD  CONSTRAINT [DF_Ant_SMS_col_creator_id]  DEFAULT ((1)) FOR [col_creator_id]
GO
/****** Object:  Default [DF_Ant_SMS_col_creator_name]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[rtc_sms] ADD  CONSTRAINT [DF_Ant_SMS_col_creator_name]  DEFAULT ('') FOR [col_creator_name]
GO
/****** Object:  Default [DF_Ant_SMS_col_dt_create]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[rtc_sms] ADD  CONSTRAINT [DF_Ant_SMS_col_dt_create]  DEFAULT (getdate()) FOR [col_dt_create]
GO
/****** Object:  Default [DF_Ant_SMS_col_status]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[rtc_sms] ADD  CONSTRAINT [DF_Ant_SMS_col_status]  DEFAULT ((0)) FOR [col_status]
GO
/****** Object:  Default [DF_Ant_SMS_col_return]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[rtc_sms] ADD  CONSTRAINT [DF_Ant_SMS_col_return]  DEFAULT ('') FOR [col_return]
GO
/****** Object:  Default [DF_Ant_SMS_col_flag]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[rtc_sms] ADD  CONSTRAINT [DF_Ant_SMS_col_flag]  DEFAULT ((0)) FOR [col_flag]
GO
/****** Object:  Default [DF_Ant_SMS_col_send_loginname]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[rtc_sms] ADD  CONSTRAINT [DF_Ant_SMS_col_send_loginname]  DEFAULT ('') FOR [col_send_loginname]
GO
/****** Object:  Default [DF_ant_keyword_col_type]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[rtc_keyword] ADD  CONSTRAINT [DF_ant_keyword_col_type]  DEFAULT ((0)) FOR [col_type]
GO
/****** Object:  Default [DF_ant_keyword_col_keyword]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[rtc_keyword] ADD  CONSTRAINT [DF_ant_keyword_col_keyword]  DEFAULT ('') FOR [col_keyword]
GO
/****** Object:  Default [DF_ant_keyword_col_date]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[rtc_keyword] ADD  CONSTRAINT [DF_ant_keyword_col_date]  DEFAULT ('') FOR [col_date]
GO
/****** Object:  Default [DF_Role_PtpSize]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Role] ADD  CONSTRAINT [DF_Role_PtpSize]  DEFAULT ((0)) FOR [PtpSize]
GO
/****** Object:  Default [DF_Role_PubSize]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Role] ADD  CONSTRAINT [DF_Role_PubSize]  DEFAULT ((0)) FOR [PubSize]
GO
/****** Object:  Default [DF_Role_ClotSize]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Role] ADD  CONSTRAINT [DF_Role_ClotSize]  DEFAULT ((0)) FOR [ClotSize]
GO
/****** Object:  Default [DF_Role_UsersSize]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Role] ADD  CONSTRAINT [DF_Role_UsersSize]  DEFAULT ((0)) FOR [UsersSize]
GO
/****** Object:  Default [DF_Role_DepartmentPermission]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Role] ADD  CONSTRAINT [DF_Role_DepartmentPermission]  DEFAULT ((0)) FOR [DepartmentPermission]
GO
/****** Object:  Default [DF_Role_SmsCount]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Role] ADD  CONSTRAINT [DF_Role_SmsCount]  DEFAULT ((0)) FOR [SmsCount]
GO
/****** Object:  Default [DF_Role_DefaultRole]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Role] ADD  CONSTRAINT [DF_Role_DefaultRole]  DEFAULT ((0)) FOR [DefaultRole]
GO
/****** Object:  Default [DF_Role_CreatorID]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Role] ADD  CONSTRAINT [DF_Role_CreatorID]  DEFAULT ((1)) FOR [CreatorID]
GO
/****** Object:  Default [DF_Role_CreatorName]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Role] ADD  CONSTRAINT [DF_Role_CreatorName]  DEFAULT ('admin') FOR [CreatorName]
GO
/****** Object:  Default [DF_remote_chat_GroupId]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[remote_chat] ADD  CONSTRAINT [DF_remote_chat_GroupId]  DEFAULT ((0)) FOR [GroupId]
GO
/****** Object:  Default [DF_remote_chat_UserId]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[remote_chat] ADD  CONSTRAINT [DF_remote_chat_UserId]  DEFAULT ((0)) FOR [YouID]
GO
/****** Object:  Default [DF_remote_chat_ConnectTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[remote_chat] ADD  CONSTRAINT [DF_remote_chat_ConnectTime]  DEFAULT (getdate()) FOR [ConnectTime]
GO
/****** Object:  Default [DF_remote_chat_Status]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[remote_chat] ADD  CONSTRAINT [DF_remote_chat_Status]  DEFAULT ((0)) FOR [Status]
GO
/****** Object:  Default [DF_remote_chat_CloseRole]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[remote_chat] ADD  CONSTRAINT [DF_remote_chat_CloseRole]  DEFAULT ((0)) FOR [CloseRole]
GO
/****** Object:  Default [DF_remote_chat_Rate]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[remote_chat] ADD  CONSTRAINT [DF_remote_chat_Rate]  DEFAULT ((0)) FOR [Rate]
GO
/****** Object:  Default [DF_remote_chat_AllowUploadFile]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[remote_chat] ADD  CONSTRAINT [DF_remote_chat_AllowUploadFile]  DEFAULT ((0)) FOR [AllowUploadFile]
GO
/****** Object:  Default [DF_remote_chat_Ord]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[remote_chat] ADD  CONSTRAINT [DF_remote_chat_Ord]  DEFAULT ((0)) FOR [Ord]
GO
/****** Object:  Default [DF_PtpFolderForm_DocAce]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[PtpFolderForm] ADD  CONSTRAINT [DF_PtpFolderForm_DocAce]  DEFAULT ((1)) FOR [DocAce]
GO
/****** Object:  Default [DF_PtpFolderForm_ToDate]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[PtpFolderForm] ADD  CONSTRAINT [DF_PtpFolderForm_ToDate]  DEFAULT (getdate()) FOR [ToDate]
GO
/****** Object:  Default [DF_PtpFolderForm_ToTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[PtpFolderForm] ADD  CONSTRAINT [DF_PtpFolderForm_ToTime]  DEFAULT (getdate()) FOR [ToTime]
GO
/****** Object:  Default [DF_PtpFolder_ParentID]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[PtpFolder] ADD  CONSTRAINT [DF_PtpFolder_ParentID]  DEFAULT ((0)) FOR [ParentID]
GO
/****** Object:  Default [DF_PtpFolder_ToDate]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[PtpFolder] ADD  CONSTRAINT [DF_PtpFolder_ToDate]  DEFAULT (getdate()) FOR [ToDate]
GO
/****** Object:  Default [DF_PtpFolder_ToTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[PtpFolder] ADD  CONSTRAINT [DF_PtpFolder_ToTime]  DEFAULT (getdate()) FOR [ToTime]
GO
/****** Object:  Default [DF_PtpFolder_To_Type]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[PtpFolder] ADD  CONSTRAINT [DF_PtpFolder_To_Type]  DEFAULT ((3)) FOR [To_Type]
GO
/****** Object:  Default [DF_PtpFolder_CreatorID]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[PtpFolder] ADD  CONSTRAINT [DF_PtpFolder_CreatorID]  DEFAULT ((1)) FOR [CreatorID]
GO
/****** Object:  Default [DF_PtpFolder_CreatorName]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[PtpFolder] ADD  CONSTRAINT [DF_PtpFolder_CreatorName]  DEFAULT ('admin') FOR [CreatorName]
GO
/****** Object:  Default [DF_PtpFile_ToDate]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[PtpFile] ADD  CONSTRAINT [DF_PtpFile_ToDate]  DEFAULT (getdate()) FOR [ToDate]
GO
/****** Object:  Default [DF_PtpFile_ToTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[PtpFile] ADD  CONSTRAINT [DF_PtpFile_ToTime]  DEFAULT (getdate()) FOR [ToTime]
GO
/****** Object:  Default [DF_PtpFile_OnlineID]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[PtpFile] ADD  CONSTRAINT [DF_PtpFile_OnlineID]  DEFAULT ((0)) FOR [OnlineID]
GO
/****** Object:  Default [DF_PtpFile_FileState]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[PtpFile] ADD  CONSTRAINT [DF_PtpFile_FileState]  DEFAULT ((1)) FOR [FileState]
GO
/****** Object:  Default [DF_PtpFile_CreatorID]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[PtpFile] ADD  CONSTRAINT [DF_PtpFile_CreatorID]  DEFAULT ((1)) FOR [CreatorID]
GO
/****** Object:  Default [DF_PtpFile_CreatorName]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[PtpFile] ADD  CONSTRAINT [DF_PtpFile_CreatorName]  DEFAULT ('admin') FOR [CreatorName]
GO
/****** Object:  Default [DF_PlugVesr_Plug_Bie]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[PlugVesr] ADD  CONSTRAINT [DF_PlugVesr_Plug_Bie]  DEFAULT ((0)) FOR [Plug_Bie]
GO
/****** Object:  Default [DF_PlugVesr_Plug_Vesr]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[PlugVesr] ADD  CONSTRAINT [DF_PlugVesr_Plug_Vesr]  DEFAULT ((0)) FOR [Plug_Vesr]
GO
/****** Object:  Default [DF_Plug_Plug_Enabled]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Plug] ADD  CONSTRAINT [DF_Plug_Plug_Enabled]  DEFAULT ((1)) FOR [Plug_Enabled]
GO
/****** Object:  Default [DF_Plug_Plug_Index]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Plug] ADD  CONSTRAINT [DF_Plug_Plug_Index]  DEFAULT ((0)) FOR [Plug_Index]
GO
/****** Object:  Default [DF_Plug_Plug_Bie]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Plug] ADD  CONSTRAINT [DF_Plug_Plug_Bie]  DEFAULT ((0)) FOR [Plug_Bie]
GO
/****** Object:  Default [DF_OtherForm_WebRun]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[OtherForm] ADD  CONSTRAINT [DF_OtherForm_WebRun]  DEFAULT ((0)) FOR [WebRun]
GO
/****** Object:  Default [DF_OtherForm_Logo]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[OtherForm] ADD  CONSTRAINT [DF_OtherForm_Logo]  DEFAULT ((0)) FOR [Logo]
GO
/****** Object:  Default [DF_OtherForm_UserApply]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[OtherForm] ADD  CONSTRAINT [DF_OtherForm_UserApply]  DEFAULT ((0)) FOR [UserApply]
GO
/****** Object:  Default [DF_OnlineRevisedFile_ToDate]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[OnlineRevisedFile] ADD  CONSTRAINT [DF_OnlineRevisedFile_ToDate]  DEFAULT (getdate()) FOR [ToDate]
GO
/****** Object:  Default [DF_OnlineRevisedFile_ToTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[OnlineRevisedFile] ADD  CONSTRAINT [DF_OnlineRevisedFile_ToTime]  DEFAULT (getdate()) FOR [ToTime]
GO
/****** Object:  Default [DF_OnlineHeat_ToDate]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[OnlineHeat] ADD  CONSTRAINT [DF_OnlineHeat_ToDate]  DEFAULT (getdate()) FOR [ToDate]
GO
/****** Object:  Default [DF_OnlineHeat_ToTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[OnlineHeat] ADD  CONSTRAINT [DF_OnlineHeat_ToTime]  DEFAULT (getdate()) FOR [ToTime]
GO
/****** Object:  Default [DF_OnlineHeat_IsTop]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[OnlineHeat] ADD  CONSTRAINT [DF_OnlineHeat_IsTop]  DEFAULT ((0)) FOR [IsTop]
GO
/****** Object:  Default [DF_OnlineForm_Authority]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[OnlineForm] ADD  CONSTRAINT [DF_OnlineForm_Authority]  DEFAULT ((0)) FOR [Authority]
GO
/****** Object:  Default [DF_OnlineForm_ToDate]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[OnlineForm] ADD  CONSTRAINT [DF_OnlineForm_ToDate]  DEFAULT (getdate()) FOR [ToDate]
GO
/****** Object:  Default [DF_OnlineForm_ToTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[OnlineForm] ADD  CONSTRAINT [DF_OnlineForm_ToTime]  DEFAULT (getdate()) FOR [ToTime]
GO
/****** Object:  Default [DF_OnlineForm_IsTop]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[OnlineForm] ADD  CONSTRAINT [DF_OnlineForm_IsTop]  DEFAULT ((0)) FOR [IsTop]
GO
/****** Object:  Default [DF_OnlineFile_ToDate]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[OnlineFile] ADD  CONSTRAINT [DF_OnlineFile_ToDate]  DEFAULT (getdate()) FOR [ToDate]
GO
/****** Object:  Default [DF_OnlineFile_ToTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[OnlineFile] ADD  CONSTRAINT [DF_OnlineFile_ToTime]  DEFAULT (getdate()) FOR [ToTime]
GO
/****** Object:  Default [DF_OnlineFile_To_Type]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[OnlineFile] ADD  CONSTRAINT [DF_OnlineFile_To_Type]  DEFAULT ((7)) FOR [FormFileType]
GO
/****** Object:  Default [DF_OnlineFile_Authority1]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[OnlineFile] ADD  CONSTRAINT [DF_OnlineFile_Authority1]  DEFAULT ((0)) FOR [Authority1]
GO
/****** Object:  Default [DF_OnlineFile_Authority2]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[OnlineFile] ADD  CONSTRAINT [DF_OnlineFile_Authority2]  DEFAULT ((0)) FOR [Authority2]
GO
ALTER TABLE [dbo].[OnlineFile] ADD  CONSTRAINT [DF_OnlineFile_Authority3]  DEFAULT ((1)) FOR [Authority3]
GO
/****** Object:  Default [DF_OnlineFile_IsTop]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[OnlineFile] ADD  CONSTRAINT [DF_OnlineFile_IsTop]  DEFAULT ((0)) FOR [IsTop]
GO
/****** Object:  Default [DF_OnlineFile_FileState]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[OnlineFile] ADD  CONSTRAINT [DF_OnlineFile_FileState]  DEFAULT ((1)) FOR [FileState]
GO
/****** Object:  Default [DF_Notice_Acks_IsAck1]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Notice_Acks] ADD  CONSTRAINT [DF_Notice_Acks_IsAck1]  DEFAULT ((0)) FOR [IsAck1]
GO
/****** Object:  Default [DF_Notice_Acks_IsAck2]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Notice_Acks] ADD  CONSTRAINT [DF_Notice_Acks_IsAck2]  DEFAULT ((0)) FOR [IsAck2]
GO
ALTER TABLE [dbo].[Notice_Acks] ADD  CONSTRAINT [DF_Notice_Acks_To_Date]  DEFAULT (getdate()) FOR [To_Date]
GO
/****** Object:  Default [DF_News_Form_ToType]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[News_Form] ADD  CONSTRAINT [DF_News_Form_ToType]  DEFAULT ((1)) FOR [ToType]
GO
/****** Object:  Default [DF_News_Form_LookOver]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[News_Form] ADD  CONSTRAINT [DF_News_Form_LookOver]  DEFAULT ((0)) FOR [LookOver]
GO
/****** Object:  Default [DF_MyTel_Form_ToDate]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MyTel_Form] ADD  CONSTRAINT [DF_MyTel_Form_ToDate]  DEFAULT (getdate()) FOR [ToDate]
GO
/****** Object:  Default [DF_Msg_Acks_IsReceipt]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Msg_Acks] ADD  CONSTRAINT [DF_Msg_Acks_IsReceipt]  DEFAULT ((0)) FOR [IsReceipt1]
GO
/****** Object:  Default [DF_Msg_Acks_IsReceipt2]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Msg_Acks] ADD  CONSTRAINT [DF_Msg_Acks_IsReceipt2]  DEFAULT ((0)) FOR [IsReceipt2]
GO
ALTER TABLE [dbo].[Msg_Acks] ADD  CONSTRAINT [DF_Msg_Acks_To_Date]  DEFAULT (getdate()) FOR [To_Date]
GO
ALTER TABLE [dbo].[Msg_Acks] ADD  CONSTRAINT [DF_Msg_Acks_To_Time]  DEFAULT (getdate()) FOR [To_Time]
GO
/****** Object:  Default [DF_MessengVerify_Type_To_Type1]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MessengVerify_Type] ADD  CONSTRAINT [DF_MessengVerify_Type_To_Type1]  DEFAULT ((0)) FOR [To_Type1]
GO
/****** Object:  Default [DF_MessengVerify_Type_To_Type2]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MessengVerify_Type] ADD  CONSTRAINT [DF_MessengVerify_Type_To_Type2]  DEFAULT ((0)) FOR [To_Type2]
GO
/****** Object:  Default [DF_MessengVerify_Type_To_Type3]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MessengVerify_Type] ADD  CONSTRAINT [DF_MessengVerify_Type_To_Type3]  DEFAULT ((0)) FOR [To_Type3]
GO
/****** Object:  Default [DF_MessengVerify_Type_To_Type4]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MessengVerify_Type] ADD  CONSTRAINT [DF_MessengVerify_Type_To_Type4]  DEFAULT ((0)) FOR [To_Type4]
GO
/****** Object:  Default [DF_MessengVerify_Blacklist_To_Type]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MessengVerify_Blacklist] ADD  CONSTRAINT [DF_MessengVerify_Blacklist_To_Type]  DEFAULT ((0)) FOR [To_Type]
GO
/****** Object:  Default [DF_MessengTel_Text_To_Type]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MessengTel_Text] ADD  CONSTRAINT [DF_MessengTel_Text_To_Type]  DEFAULT ((1)) FOR [To_Type]
GO
/****** Object:  Default [DF_MessengTel_Text_To_Date]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MessengTel_Text] ADD  CONSTRAINT [DF_MessengTel_Text_To_Date]  DEFAULT (getdate()) FOR [To_Date]
GO
/****** Object:  Default [DF_MessengTel_Text_To_Time]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MessengTel_Text] ADD  CONSTRAINT [DF_MessengTel_Text_To_Time]  DEFAULT (getdate()) FOR [To_Time]
GO
/****** Object:  Default [DF_MessengNotice_Text_To_Date]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MessengNotice_Text] ADD  CONSTRAINT [DF_MessengNotice_Text_To_Date]  DEFAULT (getdate()) FOR [To_Date]
GO
ALTER TABLE [dbo].[MessengKefuClot_Text] ADD  CONSTRAINT [DF_MessengKefuClot_Text_PID]  DEFAULT ((0)) FOR [PID]
GO
/****** Object:  Default [DF_MessengKefuClot_Text_To_Type]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MessengKefuClot_Text] ADD  CONSTRAINT [DF_MessengKefuClot_Text_To_Type]  DEFAULT ((1)) FOR [To_Type]
GO
/****** Object:  Default [DF_MessengKefuClot_Text_To_Date]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MessengKefuClot_Text] ADD  CONSTRAINT [DF_MessengKefuClot_Text_To_Date]  DEFAULT (getdate()) FOR [To_Date]
GO
/****** Object:  Default [DF_MessengKefuClot_Text_To_Time]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MessengKefuClot_Text] ADD  CONSTRAINT [DF_MessengKefuClot_Text_To_Time]  DEFAULT (getdate()) FOR [To_Time]
GO
/****** Object:  Default [DF_MessengKefu_Type_To_Type]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MessengKefu_Type] ADD  CONSTRAINT [DF_MessengKefu_Type_To_Type]  DEFAULT ((1)) FOR [To_Type]
GO
/****** Object:  Default [DF_MessengKefu_Text_To_Type]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MessengKefu_Text] ADD  CONSTRAINT [DF_MessengKefu_Text_To_Type]  DEFAULT ((1)) FOR [To_Type]
GO
/****** Object:  Default [DF_MessengKefu_Text_IsReceipt]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MessengKefu_Text] ADD  CONSTRAINT [DF_MessengKefu_Text_IsReceipt]  DEFAULT ((0)) FOR [IsReceipt]
GO
/****** Object:  Default [DF_MessengKefu_Text_To_Date]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MessengKefu_Text] ADD  CONSTRAINT [DF_MessengKefu_Text_To_Date]  DEFAULT (getdate()) FOR [To_Date]
GO
/****** Object:  Default [DF_MessengKefu_Text_To_Time]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MessengKefu_Text] ADD  CONSTRAINT [DF_MessengKefu_Text_To_Time]  DEFAULT (getdate()) FOR [To_Time]
GO
/****** Object:  Default [DF_MessengKefu_Text_IsReceipt1]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MessengKefu_Text] ADD  CONSTRAINT [DF_MessengKefu_Text_IsReceipt1]  DEFAULT ((0)) FOR [IsReceipt1]
GO
/****** Object:  Default [DF_MessengKefu_Text_IsReceipt2]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MessengKefu_Text] ADD  CONSTRAINT [DF_MessengKefu_Text_IsReceipt2]  DEFAULT ((0)) FOR [IsReceipt2]
GO
/****** Object:  Default [DF_MessengKefu_Text_IsAck1]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MessengKefu_Text] ADD  CONSTRAINT [DF_MessengKefu_Text_IsAck1]  DEFAULT ((0)) FOR [IsAck1]
GO
/****** Object:  Default [DF_MessengKefu_Text_IsAck2]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MessengKefu_Text] ADD  CONSTRAINT [DF_MessengKefu_Text_IsAck2]  DEFAULT ((0)) FOR [IsAck2]
GO
/****** Object:  Default [DF_MessengKefu_Text_IsAck3]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MessengKefu_Text] ADD  CONSTRAINT [DF_MessengKefu_Text_IsAck3]  DEFAULT ((0)) FOR [IsAck3]
GO
/****** Object:  Default [DF_MessengKefu_Text_IsAck4]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MessengKefu_Text] ADD  CONSTRAINT [DF_MessengKefu_Text_IsAck4]  DEFAULT ((0)) FOR [IsAck4]
GO
/****** Object:  Default [DF_MessengKefu_Text_IsAck5]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MessengKefu_Text] ADD  CONSTRAINT [DF_MessengKefu_Text_IsAck5]  DEFAULT ((0)) FOR [IsAck5]
GO
/****** Object:  Default [DF_MessengKefu_Text_IsAck6]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MessengKefu_Text] ADD  CONSTRAINT [DF_MessengKefu_Text_IsAck6]  DEFAULT ((0)) FOR [IsAck6]
GO
/****** Object:  Default [DF_MessengKefu_Text_IsAck7]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MessengKefu_Text] ADD  CONSTRAINT [DF_MessengKefu_Text_IsAck7]  DEFAULT ((0)) FOR [IsAck7]
GO
/****** Object:  Default [DF_MessengKefu_Text_IsAck8]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MessengKefu_Text] ADD  CONSTRAINT [DF_MessengKefu_Text_IsAck8]  DEFAULT ((0)) FOR [IsAck8]
GO
/****** Object:  Default [DF_MessengClot_Type_To_Type]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MessengClot_Type] ADD  CONSTRAINT [DF_MessengClot_Type_To_Type]  DEFAULT ((1)) FOR [To_Type]
GO
/****** Object:  Default [DF_MessengClot_Text_To_Type]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MessengClot_Text] ADD  CONSTRAINT [DF_MessengClot_Text_To_Type]  DEFAULT ((1)) FOR [To_Type]
GO
/****** Object:  Default [DF_MessengClot_Text_To_Date]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MessengClot_Text] ADD  CONSTRAINT [DF_MessengClot_Text_To_Date]  DEFAULT (getdate()) FOR [To_Date]
GO
/****** Object:  Default [DF_MessengClot_Text_To_Time]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MessengClot_Text] ADD  CONSTRAINT [DF_MessengClot_Text_To_Time]  DEFAULT (getdate()) FOR [To_Time]
GO
/****** Object:  Default [DF_Messeng_Type_To_Type]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Messeng_Type] ADD  CONSTRAINT [DF_Messeng_Type_To_Type]  DEFAULT ((1)) FOR [To_Type]
GO
/****** Object:  Default [DF_Messeng_Text_To_Type]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Messeng_Text] ADD  CONSTRAINT [DF_Messeng_Text_To_Type]  DEFAULT ((1)) FOR [To_Type]
GO
/****** Object:  Default [DF_Messeng_Text_IsReceipt]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Messeng_Text] ADD  CONSTRAINT [DF_Messeng_Text_IsReceipt]  DEFAULT ((0)) FOR [IsReceipt]
GO
/****** Object:  Default [DF_Messeng_Text_To_Date]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Messeng_Text] ADD  CONSTRAINT [DF_Messeng_Text_To_Date]  DEFAULT (getdate()) FOR [To_Date]
GO
/****** Object:  Default [DF_Messeng_Text_To_Time]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Messeng_Text] ADD  CONSTRAINT [DF_Messeng_Text_To_Time]  DEFAULT (getdate()) FOR [To_Time]
GO
/****** Object:  Default [DF_Messeng_Text_IsReceipt1]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Messeng_Text] ADD  CONSTRAINT [DF_Messeng_Text_IsReceipt1]  DEFAULT ((0)) FOR [IsReceipt1]
GO
/****** Object:  Default [DF_Messeng_Text_IsReceipt2]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Messeng_Text] ADD  CONSTRAINT [DF_Messeng_Text_IsReceipt2]  DEFAULT ((0)) FOR [IsReceipt2]
GO
/****** Object:  Default [DF_Messeng_Text_IsAck1]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Messeng_Text] ADD  CONSTRAINT [DF_Messeng_Text_IsAck1]  DEFAULT ((0)) FOR [IsAck1]
GO
/****** Object:  Default [DF_Messeng_Text_IsAck2]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Messeng_Text] ADD  CONSTRAINT [DF_Messeng_Text_IsAck2]  DEFAULT ((0)) FOR [IsAck2]
GO
/****** Object:  Default [DF_Messeng_Text_IsAck3]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Messeng_Text] ADD  CONSTRAINT [DF_Messeng_Text_IsAck3]  DEFAULT ((0)) FOR [IsAck3]
GO
/****** Object:  Default [DF_Messeng_Text_IsAck4]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Messeng_Text] ADD  CONSTRAINT [DF_Messeng_Text_IsAck4]  DEFAULT ((0)) FOR [IsAck4]
GO
/****** Object:  Default [DF_Messeng_Text_IsAck5]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Messeng_Text] ADD  CONSTRAINT [DF_Messeng_Text_IsAck5]  DEFAULT ((0)) FOR [IsAck5]
GO
/****** Object:  Default [DF_Messeng_Text_IsAck6]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Messeng_Text] ADD  CONSTRAINT [DF_Messeng_Text_IsAck6]  DEFAULT ((0)) FOR [IsAck6]
GO
/****** Object:  Default [DF_Messeng_Text_IsAck7]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Messeng_Text] ADD  CONSTRAINT [DF_Messeng_Text_IsAck7]  DEFAULT ((0)) FOR [IsAck7]
GO
/****** Object:  Default [DF_Messeng_Text_IsAck8]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Messeng_Text] ADD  CONSTRAINT [DF_Messeng_Text_IsAck8]  DEFAULT ((0)) FOR [IsAck8]
GO
/****** Object:  Default [DF_MD5File_FormFileType]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MD5File] ADD  CONSTRAINT [DF_MD5File_FormFileType]  DEFAULT ((0)) FOR [FormFileType]
GO
/****** Object:  Default [DF_MD5File_ToDate]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MD5File] ADD  CONSTRAINT [DF_MD5File_ToDate]  DEFAULT (getdate()) FOR [ToDate]
GO
/****** Object:  Default [DF_MD5File_ToTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[MD5File] ADD  CONSTRAINT [DF_MD5File_ToTime]  DEFAULT (getdate()) FOR [ToTime]
GO
ALTER TABLE [dbo].[MD5BigFile] ADD  CONSTRAINT [DF_BigFile_FormFileType]  DEFAULT ((0)) FOR [FormFileType]
GO
ALTER TABLE [dbo].[MD5BigFile] ADD  CONSTRAINT [DF_BigFile_ToDate]  DEFAULT (getdate()) FOR [ToDate]
GO
ALTER TABLE [dbo].[MD5BigFile] ADD  CONSTRAINT [DF_BigFile_ToTime]  DEFAULT (getdate()) FOR [ToTime]
GO
ALTER TABLE [dbo].[MD5BigFile] ADD  CONSTRAINT [DF_BigFile_BlobNum]  DEFAULT ((0)) FOR [BlobNum]
GO
ALTER TABLE [dbo].[MD5VideoFile] ADD  CONSTRAINT [DF_MD5VideoFile_FormFileType]  DEFAULT ((0)) FOR [FormFileType]
GO
ALTER TABLE [dbo].[MD5VideoFile] ADD  CONSTRAINT [DF_MD5VideoFile_ToDate]  DEFAULT (getdate()) FOR [ToDate]
GO
ALTER TABLE [dbo].[MD5VideoFile] ADD  CONSTRAINT [DF_MD5VideoFile_ToTime]  DEFAULT (getdate()) FOR [ToTime]
GO
/****** Object:  Default [DF_lv_user_ro_To_Type]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_user_ro] ADD  CONSTRAINT [DF_lv_user_ro_To_Type]  DEFAULT ((0)) FOR [To_Type]
GO
/****** Object:  Default [DF_lv_user_ro_Status]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_user_ro] ADD  CONSTRAINT [DF_lv_user_ro_Status]  DEFAULT ((0)) FOR [Status]
GO
/****** Object:  Default [DF_lv_user_ro_Ord]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_user_ro] ADD  CONSTRAINT [DF_lv_user_ro_Ord]  DEFAULT ((0)) FOR [Ord]
GO
/****** Object:  Default [DF_lv_user_ro_CreateTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_user_ro] ADD  CONSTRAINT [DF_lv_user_ro_CreateTime]  DEFAULT (getdate()) FOR [CreateTime]
GO
ALTER TABLE [dbo].[lv_user_reception] ADD  CONSTRAINT [DF_lv_user_reception_TO_Date]  DEFAULT (getdate()) FOR [TO_Date]
GO
ALTER TABLE [dbo].[lv_user_reception] ADD  CONSTRAINT [DF_lv_user_reception_To_Type]  DEFAULT ((0)) FOR [To_Type]
GO
ALTER TABLE [dbo].[lv_user_reception] ADD  CONSTRAINT [DF_lv_user_reception_ChaterReception]  DEFAULT ((0)) FOR [ChaterReception]
GO
ALTER TABLE [dbo].[lv_user_reception] ADD  CONSTRAINT [DF_lv_user_reception_Chater_roReception]  DEFAULT ((0)) FOR [Chater_RoReception]
GO
ALTER TABLE [dbo].[lv_user_reception] ADD  CONSTRAINT [DF_lv_user_reception_DefaultReception]  DEFAULT ((0)) FOR [DefaultReception]
GO
/****** Object:  Default [DF_lv_user_UserId]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_user] ADD  CONSTRAINT [DF_lv_user_UserId]  DEFAULT ((0)) FOR [UserId]
GO
ALTER TABLE [dbo].[lv_user] ADD  CONSTRAINT [DF_lv_user_cookieHCID5]  DEFAULT ((0)) FOR [cookieHCID5]
GO
ALTER TABLE [dbo].[lv_user] ADD  CONSTRAINT [DF_lv_user_cookieHCID6]  DEFAULT ((0)) FOR [cookieHCID6]
GO
ALTER TABLE [dbo].[lv_user] ADD  CONSTRAINT [DF_lv_user_cookieHCID7]  DEFAULT ((0)) FOR [cookieHCID7]
GO
ALTER TABLE [dbo].[lv_user] ADD  CONSTRAINT [DF_lv_user_cookieHCID8]  DEFAULT ((0)) FOR [cookieHCID8]
GO
/****** Object:  Default [DF_lv_user_RegTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_user] ADD  CONSTRAINT [DF_lv_user_RegTime]  DEFAULT (getdate()) FOR [RegTime]
GO
/****** Object:  Default [DF_lv_user_UserIcoLine]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_user] ADD  CONSTRAINT [DF_lv_user_UserIcoLine]  DEFAULT ((0)) FOR [UserIcoLine]
GO
/****** Object:  Default [DF_lv_user_Status]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_user] ADD  CONSTRAINT [DF_lv_user_Status]  DEFAULT ((0)) FOR [Status]
GO
/****** Object:  Default [DF_lv_user_IsWeb]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_user] ADD  CONSTRAINT [DF_lv_user_IsWeb]  DEFAULT ((0)) FOR [IsWeb]
GO
/****** Object:  Default [DF_lv_user_ChatCount]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_user] ADD  CONSTRAINT [DF_lv_user_ChatCount]  DEFAULT ((0)) FOR [ChatCount]
GO
/****** Object:  Default [DF_lv_user_maxTypeID]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_user] ADD  CONSTRAINT [DF_lv_user_maxTypeID]  DEFAULT ((0)) FOR [maxTypeID]
GO
/****** Object:  Default [DF_lv_user_IsWeiXin]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_user] ADD  CONSTRAINT [DF_lv_user_IsWeiXin]  DEFAULT ((0)) FOR [IsWeiXin]
GO
/****** Object:  Default [DF_lv_user_subscribe]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_user] ADD  CONSTRAINT [DF_lv_user_subscribe]  DEFAULT ((0)) FOR [subscribe]
GO
/****** Object:  Default [DF_lv_user_sex]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_user] ADD  CONSTRAINT [DF_lv_user_sex]  DEFAULT ((0)) FOR [sex]
GO
/****** Object:  Default [DF_lv_transfer_To_Type]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_transfer] ADD  CONSTRAINT [DF_lv_transfer_To_Type]  DEFAULT ((1)) FOR [To_Type]
GO
/****** Object:  Default [DF_lv_transfer_Todate]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_transfer] ADD  CONSTRAINT [DF_lv_transfer_Todate]  DEFAULT (getdate()) FOR [Todate]
GO
/****** Object:  Default [DF_lv_track_GroupId]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_track] ADD  CONSTRAINT [DF_lv_track_GroupId]  DEFAULT ((0)) FOR [GroupId]
GO
/****** Object:  Default [DF_lv_track_Flag]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_track] ADD  CONSTRAINT [DF_lv_track_Flag]  DEFAULT ((0)) FOR [Flag]
GO
/****** Object:  Default [DF_lv_track_CreateTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_track] ADD  CONSTRAINT [DF_lv_track_CreateTime]  DEFAULT (getdate()) FOR [InTime]
GO
/****** Object:  Default [DF_lv_track_Ord]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_track] ADD  CONSTRAINT [DF_lv_track_Ord]  DEFAULT ((0)) FOR [Ord]
GO
/****** Object:  Default [DF_lv_source_GroupId]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_source] ADD  CONSTRAINT [DF_lv_source_GroupId]  DEFAULT ((0)) FOR [GroupId]
GO
/****** Object:  Default [DF_lv_source_Flag]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_source] ADD  CONSTRAINT [DF_lv_source_Flag]  DEFAULT ((0)) FOR [Flag]
GO
/****** Object:  Default [DF_lv_source_CreateTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_source] ADD  CONSTRAINT [DF_lv_source_CreateTime]  DEFAULT (getdate()) FOR [InTime]
GO
/****** Object:  Default [DF_lv_source_Ord]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_source] ADD  CONSTRAINT [DF_lv_source_Ord]  DEFAULT ((0)) FOR [Ord]
GO
/****** Object:  Default [DF_lv_quick_talk_TalkId]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_quicktalk] ADD  CONSTRAINT [DF_lv_quick_talk_TalkId]  DEFAULT ((0)) FOR [TalkId]
GO
/****** Object:  Default [DF_lv_quick_talk_To_Type]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_quicktalk] ADD  CONSTRAINT [DF_lv_quick_talk_To_Type]  DEFAULT ((0)) FOR [To_Type]
GO
/****** Object:  Default [DF_lv_quick_talk_Status]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_quicktalk] ADD  CONSTRAINT [DF_lv_quick_talk_Status]  DEFAULT ((0)) FOR [Status]
GO
/****** Object:  Default [DF_lv_quick_talk_Ord]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_quicktalk] ADD  CONSTRAINT [DF_lv_quick_talk_Ord]  DEFAULT ((0)) FOR [Ord]
GO
/****** Object:  Default [DF_lv_quick_talk_CreateTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_quicktalk] ADD  CONSTRAINT [DF_lv_quick_talk_CreateTime]  DEFAULT (getdate()) FOR [CreateTime]
GO
/****** Object:  Default [DF_lv_question_QuestionId]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_question] ADD  CONSTRAINT [DF_lv_question_QuestionId]  DEFAULT ((0)) FOR [QuestionId]
GO
/****** Object:  Default [DF_lv_question_To_Type]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_question] ADD  CONSTRAINT [DF_lv_question_To_Type]  DEFAULT ((0)) FOR [To_Type]
GO
/****** Object:  Default [DF_lv_question_col_match]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_question] ADD  CONSTRAINT [DF_lv_question_col_match]  DEFAULT ((0)) FOR [col_match]
GO
/****** Object:  Default [DF_lv_question_col_receive]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_question] ADD  CONSTRAINT [DF_lv_question_col_receive]  DEFAULT ((0)) FOR [col_receive]
GO
/****** Object:  Default [DF_lv_question_col_top]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_question] ADD  CONSTRAINT [DF_lv_question_col_top]  DEFAULT ((0)) FOR [col_top]
GO
/****** Object:  Default [DF_lv_question_Status]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_question] ADD  CONSTRAINT [DF_lv_question_Status]  DEFAULT ((0)) FOR [Status]
GO
/****** Object:  Default [DF_lv_question_Ord]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_question] ADD  CONSTRAINT [DF_lv_question_Ord]  DEFAULT ((0)) FOR [Ord]
GO
/****** Object:  Default [DF_lv_question_CreateTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_question] ADD  CONSTRAINT [DF_lv_question_CreateTime]  DEFAULT (getdate()) FOR [CreateTime]
GO
/****** Object:  Default [DF_lv_message_Id]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_message] ADD  CONSTRAINT [DF_lv_message_Id]  DEFAULT ((0)) FOR [Id]
GO
/****** Object:  Default [DF_lv_message_GroupId]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_message] ADD  CONSTRAINT [DF_lv_message_GroupId]  DEFAULT ((0)) FOR [GroupId]
GO
/****** Object:  Default [DF_lv_message_UserId]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_message] ADD  CONSTRAINT [DF_lv_message_UserId]  DEFAULT ((0)) FOR [UserId]
GO
/****** Object:  Default [DF_lv_message_CreateTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_message] ADD  CONSTRAINT [DF_lv_message_CreateTime]  DEFAULT (getdate()) FOR [CreateTime]
GO
/****** Object:  Default [DF_lv_link_LinkId]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_link] ADD  CONSTRAINT [DF_lv_link_LinkId]  DEFAULT ((0)) FOR [LinkId]
GO
/****** Object:  Default [DF_lv_link_LinkType]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_link] ADD  CONSTRAINT [DF_lv_link_LinkType]  DEFAULT ((0)) FOR [LinkType]
GO
/****** Object:  Default [DF_lv_link_Ord]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_link] ADD  CONSTRAINT [DF_lv_link_Ord]  DEFAULT ((0)) FOR [Ord]
GO
/****** Object:  Default [DF_lv_link_CreateTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_link] ADD  CONSTRAINT [DF_lv_link_CreateTime]  DEFAULT (getdate()) FOR [CreateTime]
GO
/****** Object:  Default [DF_lv_file_FileId]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_file] ADD  CONSTRAINT [DF_lv_file_FileId]  DEFAULT ((0)) FOR [FileId]
GO
/****** Object:  Default [DF_lv_file_GroupId]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_file] ADD  CONSTRAINT [DF_lv_file_GroupId]  DEFAULT ((0)) FOR [GroupId]
GO
/****** Object:  Default [DF_lv_file_FileSize]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_file] ADD  CONSTRAINT [DF_lv_file_FileSize]  DEFAULT ((0)) FOR [FileSize]
GO
/****** Object:  Default [DF_lv_file_Flag]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_file] ADD  CONSTRAINT [DF_lv_file_Flag]  DEFAULT ((0)) FOR [Flag]
GO
/****** Object:  Default [DF_lv_file_CreateTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_file] ADD  CONSTRAINT [DF_lv_file_CreateTime]  DEFAULT (getdate()) FOR [CreateTime]
GO
/****** Object:  Default [DF_lv_file_Ord]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_file] ADD  CONSTRAINT [DF_lv_file_Ord]  DEFAULT ((0)) FOR [Ord]
GO
/****** Object:  Default [DF_lv_chater_wechat_GroupId]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_wechat] ADD  CONSTRAINT [DF_lv_chater_wechat_GroupId]  DEFAULT ((0)) FOR [GroupId]
GO
/****** Object:  Default [DF_lv_chater_wechat_subscribe]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_wechat] ADD  CONSTRAINT [DF_lv_chater_wechat_subscribe]  DEFAULT ((0)) FOR [subscribe]
GO
/****** Object:  Default [DF_lv_chater_wechat_Status]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_wechat] ADD  CONSTRAINT [DF_lv_chater_wechat_Status]  DEFAULT ((0)) FOR [Status]
GO
/****** Object:  Default [DF_lv_chater_wechat_Ord]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_wechat] ADD  CONSTRAINT [DF_lv_chater_wechat_Ord]  DEFAULT ((0)) FOR [Ord]
GO
/****** Object:  Default [DF_lv_chater_wechat_CreateTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_wechat] ADD  CONSTRAINT [DF_lv_chater_wechat_CreateTime]  DEFAULT (getdate()) FOR [CreateTime]
GO
/****** Object:  Default [DF_lv_chater_theme_GroupId]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_theme] ADD  CONSTRAINT [DF_lv_chater_theme_GroupId]  DEFAULT ((0)) FOR [GroupId]
GO
/****** Object:  Default [DF_lv_chater_theme_Status]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_theme] ADD  CONSTRAINT [DF_lv_chater_theme_Status]  DEFAULT ((0)) FOR [Status]
GO
/****** Object:  Default [DF_lv_chater_theme_Ord]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_theme] ADD  CONSTRAINT [DF_lv_chater_theme_Ord]  DEFAULT ((0)) FOR [Ord]
GO
/****** Object:  Default [DF_lv_chater_theme_CreateTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_theme] ADD  CONSTRAINT [DF_lv_chater_theme_CreateTime]  DEFAULT (getdate()) FOR [CreateTime]
GO
/****** Object:  Default [DF_lv_chater_ro_To_Type]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_ro] ADD  CONSTRAINT [DF_lv_chater_ro_To_Type]  DEFAULT ((0)) FOR [To_Type]
GO
/****** Object:  Default [DF_lv_chater_ro_Status]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_ro] ADD  CONSTRAINT [DF_lv_chater_ro_Status]  DEFAULT ((0)) FOR [Status]
GO
ALTER TABLE [dbo].[lv_chater_ro] ADD  CONSTRAINT [DF_lv_chater_ro_DefaultReception]  DEFAULT ((0)) FOR [DefaultReception]
GO
/****** Object:  Default [DF_Table_1_ItemIndex]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_ro] ADD  CONSTRAINT [DF_Table_1_ItemIndex]  DEFAULT ((0)) FOR [Ord]
GO
/****** Object:  Default [DF_lv_chater_ro_CreateTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_ro] ADD  CONSTRAINT [DF_lv_chater_ro_CreateTime]  DEFAULT (getdate()) FOR [CreateTime]
GO
/****** Object:  Default [DF_KefuMsg_Acks_IsReceipt]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_KefuMsg_Acks] ADD  CONSTRAINT [DF_KefuMsg_Acks_IsReceipt]  DEFAULT ((0)) FOR [IsReceipt1]
GO
/****** Object:  Default [DF_KefuMsg_Acks_IsReceipt2]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_KefuMsg_Acks] ADD  CONSTRAINT [DF_KefuMsg_Acks_IsReceipt2]  DEFAULT ((0)) FOR [IsReceipt2]
GO
ALTER TABLE [dbo].[lv_chater_KefuMsg_Acks] ADD  CONSTRAINT [DF_lv_chater_KefuMsg_Acks_To_Date]  DEFAULT (getdate()) FOR [To_Date]
GO
ALTER TABLE [dbo].[lv_chater_KefuMsg_Acks] ADD  CONSTRAINT [DF_lv_chater_KefuMsg_Acks_To_Time]  DEFAULT (getdate()) FOR [To_Time]
GO
/****** Object:  Default [DF_lv_chater_domain_GroupId]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_domain] ADD  CONSTRAINT [DF_lv_chater_domain_GroupId]  DEFAULT ((0)) FOR [GroupId]
GO
/****** Object:  Default [DF_lv_chater_domain_Status]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_domain] ADD  CONSTRAINT [DF_lv_chater_domain_Status]  DEFAULT ((0)) FOR [Status]
GO
/****** Object:  Default [DF_lv_chater_domain_Ord]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_domain] ADD  CONSTRAINT [DF_lv_chater_domain_Ord]  DEFAULT ((0)) FOR [Ord]
GO
/****** Object:  Default [DF_lv_chater_domain_CreateTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_domain] ADD  CONSTRAINT [DF_lv_chater_domain_CreateTime]  DEFAULT (getdate()) FOR [CreateTime]
GO
/****** Object:  Default [DF_lv_chater_Clot_Ro_To_Date]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_Clot_Ro] ADD  CONSTRAINT [DF_lv_chater_Clot_Ro_To_Date]  DEFAULT (getdate()) FOR [To_Date]
GO
/****** Object:  Default [DF_lv_chater_Clot_Ro_Sender]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_Clot_Ro] ADD  CONSTRAINT [DF_lv_chater_Clot_Ro_Sender]  DEFAULT ((0)) FOR [Sender]
GO
/****** Object:  Default [DF_lv_chater_Clot_Ro_UserState]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_Clot_Ro] ADD  CONSTRAINT [DF_lv_chater_Clot_Ro_UserState]  DEFAULT ((0)) FOR [UserState]
GO
/****** Object:  Default [DF_lv_chater_Clot_Ro_DiskSpace]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_Clot_Ro] ADD  CONSTRAINT [DF_lv_chater_Clot_Ro_DiskSpace]  DEFAULT ((1024)) FOR [Disk_Space]
GO
/****** Object:  Default [DF_lv_chater_Clot_Ro_IsPublic]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_Clot_Ro] ADD  CONSTRAINT [DF_lv_chater_Clot_Ro_IsPublic]  DEFAULT ((0)) FOR [IsPublic]
GO
/****** Object:  Default [DF_lv_chater_Clot_Ro_OwnerID]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_Clot_Ro] ADD  CONSTRAINT [DF_lv_chater_Clot_Ro_OwnerID]  DEFAULT ((1)) FOR [OwnerID]
GO
/****** Object:  Default [DF_lv_chater_Clot_Ro_ItemIndex]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_Clot_Ro] ADD  CONSTRAINT [DF_lv_chater_Clot_Ro_ItemIndex]  DEFAULT ((0)) FOR [ItemIndex]
GO
/****** Object:  Default [DF_lv_chater_Clot_Ro_CreatorID]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_Clot_Ro] ADD  CONSTRAINT [DF_lv_chater_Clot_Ro_CreatorID]  DEFAULT ((1)) FOR [CreatorID]
GO
/****** Object:  Default [DF_lv_chater_Clot_Ro_CreatorName]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_Clot_Ro] ADD  CONSTRAINT [DF_lv_chater_Clot_Ro_CreatorName]  DEFAULT ('admin') FOR [CreatorName]
GO
/****** Object:  Default [DF_lv_chater_Clot_Ro_Users_IDVesr]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_Clot_Ro] ADD  CONSTRAINT [DF_lv_chater_Clot_Ro_Users_IDVesr]  DEFAULT ((0)) FOR [Users_IDVesr]
GO
/****** Object:  Default [DF_lv_chater_Clot_Ro_Users_FormVesr]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_Clot_Ro] ADD  CONSTRAINT [DF_lv_chater_Clot_Ro_Users_FormVesr]  DEFAULT ((0)) FOR [Users_FormVesr]
GO
/****** Object:  Default [DF_lv_chater_Clot_Form_last_ack_typeid1]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_Clot_Form] ADD  CONSTRAINT [DF_lv_chater_Clot_Form_last_ack_typeid1]  DEFAULT ((0)) FOR [last_ack_typeid1]
GO
/****** Object:  Default [DF_lv_chater_Clot_Form_last_ack_typeid2]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_Clot_Form] ADD  CONSTRAINT [DF_lv_chater_Clot_Form_last_ack_typeid2]  DEFAULT ((0)) FOR [last_ack_typeid2]
GO
/****** Object:  Default [DF_lv_chater_Clot_Form_last_ack_typeid3]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_Clot_Form] ADD  CONSTRAINT [DF_lv_chater_Clot_Form_last_ack_typeid3]  DEFAULT ((0)) FOR [last_ack_typeid3]
GO
/****** Object:  Default [DF_lv_chater_Clot_Form_last_ack_typeid4]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_Clot_Form] ADD  CONSTRAINT [DF_lv_chater_Clot_Form_last_ack_typeid4]  DEFAULT ((0)) FOR [last_ack_typeid4]
GO
/****** Object:  Default [DF_lv_chater_Clot_Form_last_ack_typeid5]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_Clot_Form] ADD  CONSTRAINT [DF_lv_chater_Clot_Form_last_ack_typeid5]  DEFAULT ((0)) FOR [last_ack_typeid5]
GO
/****** Object:  Default [DF_lv_chater_Clot_Form_last_ack_typeid6]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_Clot_Form] ADD  CONSTRAINT [DF_lv_chater_Clot_Form_last_ack_typeid6]  DEFAULT ((0)) FOR [last_ack_typeid6]
GO
/****** Object:  Default [DF_lv_chater_Clot_Form_last_ack_typeid7]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_Clot_Form] ADD  CONSTRAINT [DF_lv_chater_Clot_Form_last_ack_typeid7]  DEFAULT ((0)) FOR [last_ack_typeid7]
GO
/****** Object:  Default [DF_lv_chater_Clot_Form_last_ack_typeid8]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_Clot_Form] ADD  CONSTRAINT [DF_lv_chater_Clot_Form_last_ack_typeid8]  DEFAULT ((0)) FOR [last_ack_typeid8]
GO
/****** Object:  Default [DF_lv_chater_Clot_Ro_To_Date]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater_Clot_Form] ADD  CONSTRAINT [DF_lv_chater_Clot_Form_To_Date]  DEFAULT (getdate()) FOR [To_Date]
GO
/****** Object:  Default [DF_lv_chater_UserId]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater] ADD  CONSTRAINT [DF_lv_chater_UserId]  DEFAULT ((0)) FOR [UserId]
GO
/****** Object:  Default [DF_lv_chater_Status]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater] ADD  CONSTRAINT [DF_lv_chater_Status]  DEFAULT ((0)) FOR [Status]
GO
ALTER TABLE [dbo].[lv_chater] ADD  CONSTRAINT [DF_lv_chater_DefaultReception]  DEFAULT ((0)) FOR [DefaultReception]
GO
/****** Object:  Default [DF_lv_chater_DefaultTargetLanguage]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater] ADD  CONSTRAINT [DF_lv_chater_DefaultTargetLanguage]  DEFAULT (N'en') FOR [DefaultTargetLanguage]
GO
/****** Object:  Default [DF_lv_chater_UserAutoTranslate]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater] ADD  CONSTRAINT [DF_lv_chater_UserAutoTranslate]  DEFAULT ((0)) FOR [UserAutoTranslate]
GO
/****** Object:  Default [DF_lv_chater_UserTargetLanguage]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater] ADD  CONSTRAINT [DF_lv_chater_UserTargetLanguage]  DEFAULT (N'en') FOR [UserTargetLanguage]
GO
/****** Object:  Default [DF_lv_chater_ChaterAutoTranslate]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater] ADD  CONSTRAINT [DF_lv_chater_ChaterAutoTranslate]  DEFAULT ((0)) FOR [ChaterAutoTranslate]
GO
/****** Object:  Default [DF_lv_chater_ChaterTargetLanguage]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater] ADD  CONSTRAINT [DF_lv_chater_ChaterTargetLanguage]  DEFAULT (N'en') FOR [ChaterTargetLanguage]
GO
/****** Object:  Default [DF_lv_chater_Reception]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater] ADD  CONSTRAINT [DF_lv_chater_Reception]  DEFAULT ((1000)) FOR [Reception]
GO
/****** Object:  Default [DF_lv_chater_FreeTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater] ADD  CONSTRAINT [DF_lv_chater_FreeTime]  DEFAULT ((0)) FOR [FreeTime]
GO
ALTER TABLE [dbo].[lv_chater] ADD  CONSTRAINT [DF_lv_chater_EndSession]  DEFAULT ((0)) FOR [EndSession]
GO
/****** Object:  Default [DF_lv_chater_Ord]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chater] ADD  CONSTRAINT [DF_lv_chater_Ord]  DEFAULT ((0)) FOR [Ord]
GO
/****** Object:  Default [DF_lv_chat_GroupId]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chat] ADD  CONSTRAINT [DF_lv_chat_GroupId]  DEFAULT ((0)) FOR [GroupId]
GO
/****** Object:  Default [DF_lv_chat_UserId]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chat] ADD  CONSTRAINT [DF_lv_chat_UserId]  DEFAULT ((0)) FOR [UserId]
GO
/****** Object:  Default [DF_lv_chat_ConnectTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chat] ADD  CONSTRAINT [DF_lv_chat_ConnectTime]  DEFAULT (getdate()) FOR [ConnectTime]
GO
/****** Object:  Default [DF_lv_chat_Status]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chat] ADD  CONSTRAINT [DF_lv_chat_Status]  DEFAULT ((0)) FOR [Status]
GO
/****** Object:  Default [DF_lv_chat_CloseRole]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chat] ADD  CONSTRAINT [DF_lv_chat_CloseRole]  DEFAULT ((0)) FOR [CloseRole]
GO
/****** Object:  Default [DF_lv_chat_Rate]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chat] ADD  CONSTRAINT [DF_lv_chat_Rate]  DEFAULT ((0)) FOR [Rate]
GO
/****** Object:  Default [DF_lv_chat_ThemeId]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chat] ADD  CONSTRAINT [DF_lv_chat_ThemeId]  DEFAULT ((0)) FOR [ThemeId]
GO
/****** Object:  Default [DF_lv_chat_ChatLevel]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chat] ADD  CONSTRAINT [DF_lv_chat_ChatLevel]  DEFAULT ((0)) FOR [ChatLevel]
GO
/****** Object:  Default [DF_lv_chat_IsEnable]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chat] ADD  CONSTRAINT [DF_lv_chat_IsEnable]  DEFAULT ((0)) FOR [IsEnable]
GO
/****** Object:  Default [DF_lv_chat_AllowUploadFile]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chat] ADD  CONSTRAINT [DF_lv_chat_AllowUploadFile]  DEFAULT ((0)) FOR [AllowUploadFile]
GO
/****** Object:  Default [DF_lv_chat_Ord]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[lv_chat] ADD  CONSTRAINT [DF_lv_chat_Ord]  DEFAULT ((0)) FOR [Ord]
GO
/****** Object:  Default [DF_LeaveFile_ToDate]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[LeaveFile] ADD  CONSTRAINT [DF_LeaveFile_ToDate]  DEFAULT (getdate()) FOR [ToDate]
GO
/****** Object:  Default [DF_LeaveFile_OnlineID]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[LeaveFile] ADD  CONSTRAINT [DF_LeaveFile_OnlineID]  DEFAULT ((0)) FOR [OnlineID]
GO
/****** Object:  Default [DF_jsdl2_ID]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[jsdl2] ADD  CONSTRAINT [DF_jsdl2_ID]  DEFAULT ((0)) FOR [ID]
GO
/****** Object:  Default [DF_FontForm1_FontSize]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[FontForm1] ADD  CONSTRAINT [DF_FontForm1_FontSize]  DEFAULT ((0)) FOR [FontSize]
GO
/****** Object:  Default [DF_FontForm_FontSize]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[FontForm] ADD  CONSTRAINT [DF_FontForm_FontSize]  DEFAULT ((0)) FOR [FontSize]
GO
/****** Object:  Default [DF_Fav_Form_UpperID]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Fav_Form] ADD  CONSTRAINT [DF_Fav_Form_UpperID]  DEFAULT ((1)) FOR [UpperID]
GO
/****** Object:  Default [DF_DownLoad_TypeS]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[DownLoad] ADD  CONSTRAINT [DF_DownLoad_TypeS]  DEFAULT ((1)) FOR [TypeS]
GO
/****** Object:  Default [DF_DownLoad_ToDate]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[DownLoad] ADD  CONSTRAINT [DF_DownLoad_ToDate]  DEFAULT (getdate()) FOR [ToDate]
GO
/****** Object:  Default [DF_DownLoad_ToTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[DownLoad] ADD  CONSTRAINT [DF_DownLoad_ToTime]  DEFAULT (getdate()) FOR [ToTime]
GO
/****** Object:  Default [DF_Col_Ro_ToDate]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Col_Ro] ADD  CONSTRAINT [DF_Col_Ro_ToDate]  DEFAULT (getdate()) FOR [ToDate]
GO
/****** Object:  Default [DF_Col_Ro_ToTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Col_Ro] ADD  CONSTRAINT [DF_Col_Ro_ToTime]  DEFAULT (getdate()) FOR [ToTime]
GO
/****** Object:  Default [DF_Col_Form_ToDate]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Col_Form] ADD  CONSTRAINT [DF_Col_Form_ToDate]  DEFAULT (getdate()) FOR [ToDate]
GO
/****** Object:  Default [DF_Col_Form_ToTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Col_Form] ADD  CONSTRAINT [DF_Col_Form_ToTime]  DEFAULT (getdate()) FOR [ToTime]
GO
/****** Object:  Default [DF_ClotFile_ToDate]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[ClotFile] ADD  CONSTRAINT [DF_ClotFile_ToDate]  DEFAULT (getdate()) FOR [ToDate]
GO
/****** Object:  Default [DF_ClotFile_ToTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[ClotFile] ADD  CONSTRAINT [DF_ClotFile_ToTime]  DEFAULT (getdate()) FOR [ToTime]
GO
/****** Object:  Default [DF_ClotFile_OnlineID]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[ClotFile] ADD  CONSTRAINT [DF_ClotFile_OnlineID]  DEFAULT ((0)) FOR [OnlineID]
GO
/****** Object:  Default [DF_ClotFile_FileState]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[ClotFile] ADD  CONSTRAINT [DF_ClotFile_FileState]  DEFAULT ((1)) FOR [FileState]
GO
/****** Object:  Default [DF_Clot_Silence_TO_Date]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Clot_Silence] ADD  CONSTRAINT [DF_Clot_Silence_TO_Date]  DEFAULT (getdate()) FOR [TO_Date]
GO
/****** Object:  Default [DF_Clot_Silence_To_Type]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Clot_Silence] ADD  CONSTRAINT [DF_Clot_Silence_To_Type]  DEFAULT ((0)) FOR [To_Type]
GO
/****** Object:  Default [DF_Clot_Ro_To_Date]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Clot_Ro] ADD  CONSTRAINT [DF_Clot_Ro_To_Date]  DEFAULT (getdate()) FOR [To_Date]
GO
/****** Object:  Default [DF_Clot_Ro_Sender]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Clot_Ro] ADD  CONSTRAINT [DF_Clot_Ro_Sender]  DEFAULT ((0)) FOR [Sender]
GO
/****** Object:  Default [DF_Clot_Ro_UserState]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Clot_Ro] ADD  CONSTRAINT [DF_Clot_Ro_UserState]  DEFAULT ((0)) FOR [UserState]
GO
/****** Object:  Default [DF_Clot_Ro_DiskSpace]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Clot_Ro] ADD  CONSTRAINT [DF_Clot_Ro_DiskSpace]  DEFAULT ((1024)) FOR [Disk_Space]
GO
/****** Object:  Default [DF_Clot_Ro_IsPublic]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Clot_Ro] ADD  CONSTRAINT [DF_Clot_Ro_IsPublic]  DEFAULT ((0)) FOR [IsPublic]
GO
/****** Object:  Default [DF_Clot_Ro_OwnerID]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Clot_Ro] ADD  CONSTRAINT [DF_Clot_Ro_OwnerID]  DEFAULT ((1)) FOR [OwnerID]
GO
/****** Object:  Default [DF_Clot_Ro_ItemIndex]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Clot_Ro] ADD  CONSTRAINT [DF_Clot_Ro_ItemIndex]  DEFAULT ((0)) FOR [ItemIndex]
GO
/****** Object:  Default [DF_Clot_Ro_CreatorID]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Clot_Ro] ADD  CONSTRAINT [DF_Clot_Ro_CreatorID]  DEFAULT ((1)) FOR [CreatorID]
GO
/****** Object:  Default [DF_Clot_Ro_CreatorName]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Clot_Ro] ADD  CONSTRAINT [DF_Clot_Ro_CreatorName]  DEFAULT ('admin') FOR [CreatorName]
GO
/****** Object:  Default [DF_Clot_Ro_Users_IDVesr]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Clot_Ro] ADD  CONSTRAINT [DF_Clot_Ro_Users_IDVesr]  DEFAULT ((0)) FOR [Users_IDVesr]
GO
/****** Object:  Default [DF_Clot_Ro_Users_FormVesr]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Clot_Ro] ADD  CONSTRAINT [DF_Clot_Ro_Users_FormVesr]  DEFAULT ((0)) FOR [Users_FormVesr]
GO
/****** Object:  Default [DF_Clot_Pic_ClotInfo]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Clot_Pic] ADD  CONSTRAINT [DF_Clot_Pic_ClotInfo]  DEFAULT ((0)) FOR [ClotInfo]
GO
/****** Object:  Default [DF_Clot_Pic_pic]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Clot_Pic] ADD  CONSTRAINT [DF_Clot_Pic_pic]  DEFAULT ((0)) FOR [pic]
GO
/****** Object:  Default [DF_Clot_Pic_file]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Clot_Pic] ADD  CONSTRAINT [DF_Clot_Pic_file]  DEFAULT ((0)) FOR [Sfile]
GO
/****** Object:  Default [DF_Clot_Form_last_ack_typeid1]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Clot_Form] ADD  CONSTRAINT [DF_Clot_Form_last_ack_typeid1]  DEFAULT ((0)) FOR [last_ack_typeid1]
GO
/****** Object:  Default [DF_Clot_Form_last_ack_typeid2]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Clot_Form] ADD  CONSTRAINT [DF_Clot_Form_last_ack_typeid2]  DEFAULT ((0)) FOR [last_ack_typeid2]
GO
/****** Object:  Default [DF_Clot_Form_last_ack_typeid3]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Clot_Form] ADD  CONSTRAINT [DF_Clot_Form_last_ack_typeid3]  DEFAULT ((0)) FOR [last_ack_typeid3]
GO
/****** Object:  Default [DF_Clot_Form_last_ack_typeid4]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Clot_Form] ADD  CONSTRAINT [DF_Clot_Form_last_ack_typeid4]  DEFAULT ((0)) FOR [last_ack_typeid4]
GO
/****** Object:  Default [DF_Clot_Form_last_ack_typeid5]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Clot_Form] ADD  CONSTRAINT [DF_Clot_Form_last_ack_typeid5]  DEFAULT ((0)) FOR [last_ack_typeid5]
GO
/****** Object:  Default [DF_Clot_Form_last_ack_typeid6]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Clot_Form] ADD  CONSTRAINT [DF_Clot_Form_last_ack_typeid6]  DEFAULT ((0)) FOR [last_ack_typeid6]
GO
/****** Object:  Default [DF_Clot_Form_last_ack_typeid7]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Clot_Form] ADD  CONSTRAINT [DF_Clot_Form_last_ack_typeid7]  DEFAULT ((0)) FOR [last_ack_typeid7]
GO
/****** Object:  Default [DF_Clot_Form_last_ack_typeid8]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Clot_Form] ADD  CONSTRAINT [DF_Clot_Form_last_ack_typeid8]  DEFAULT ((0)) FOR [last_ack_typeid8]
GO
/****** Object:  Default [DF_Board_Visiter_col_dt_Create]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Board_Visiter] ADD  CONSTRAINT [DF_Board_Visiter_col_dt_Create]  DEFAULT (getdate()) FOR [col_dt_Create]
GO
/****** Object:  Default [DF_Board_Visiter_col_Readed]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Board_Visiter] ADD  CONSTRAINT [DF_Board_Visiter_col_Readed]  DEFAULT ((0)) FOR [col_Readed]
GO
/****** Object:  Default [DF_Board_Visiter_Col_HsItem_ID]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Board_Visiter] ADD  CONSTRAINT [DF_Board_Visiter_Col_HsItem_ID]  DEFAULT ((0)) FOR [Col_HsItem_ID]
GO
/****** Object:  Default [DF_Board_Attach_col_Dt_Create]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Board_Attach] ADD  CONSTRAINT [DF_Board_Attach_col_Dt_Create]  DEFAULT (getdate()) FOR [col_Dt_Create]
GO
/****** Object:  Default [DF_Board_col_Creator_ID]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Board] ADD  CONSTRAINT [DF_Board_col_Creator_ID]  DEFAULT ((0)) FOR [col_Creator_ID]
GO
/****** Object:  Default [DF_Board_col_Modifyer_ID]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Board] ADD  CONSTRAINT [DF_Board_col_Modifyer_ID]  DEFAULT ((0)) FOR [col_Modifyer_ID]
GO
/****** Object:  Default [DF_Board_Col_AttachmentCount]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Board] ADD  CONSTRAINT [DF_Board_Col_AttachmentCount]  DEFAULT ((0)) FOR [Col_AttachmentCount]
GO
/****** Object:  Default [DF_Board_Col_ClickCount]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Board] ADD  CONSTRAINT [DF_Board_Col_ClickCount]  DEFAULT ((0)) FOR [Col_ClickCount]
GO
/****** Object:  Default [DF_Board_col_Dt_Create]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Board] ADD  CONSTRAINT [DF_Board_col_Dt_Create]  DEFAULT (getdate()) FOR [col_Dt_Create]
GO
/****** Object:  Default [DF_Board_col_Order]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Board] ADD  CONSTRAINT [DF_Board_col_Order]  DEFAULT ((0)) FOR [col_Order]
GO
/****** Object:  Default [DF_Board_col_G_ClassID]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Board] ADD  CONSTRAINT [DF_Board_col_G_ClassID]  DEFAULT ((0)) FOR [col_G_ClassID]
GO
/****** Object:  Default [DF_Board_col_G_ObjID]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Board] ADD  CONSTRAINT [DF_Board_col_G_ObjID]  DEFAULT ((0)) FOR [col_G_ObjID]
GO
/****** Object:  Default [DF_Board_col_IsPublic]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Board] ADD  CONSTRAINT [DF_Board_col_IsPublic]  DEFAULT ((0)) FOR [col_IsPublic]
GO
/****** Object:  Default [DF_Board_Col_CompanyId]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Board] ADD  CONSTRAINT [DF_Board_Col_CompanyId]  DEFAULT ((0)) FOR [Col_CompanyId]
GO
/****** Object:  Default [DF_Board_Col_Creator_DeptId]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[Board] ADD  CONSTRAINT [DF_Board_Col_Creator_DeptId]  DEFAULT ((0)) FOR [Col_Creator_DeptId]
GO
/****** Object:  Default [DF_Grant_CountUser]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[AdminGrant] ADD  CONSTRAINT [DF_Grant_CountUser]  DEFAULT ((0)) FOR [CountUser]
GO
/****** Object:  Default [DF_Grant_CreateTime]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[AdminGrant] ADD  CONSTRAINT [DF_Grant_CreateTime]  DEFAULT (getdate()) FOR [CreateTime]
GO
/****** Object:  Default [DF_Grant_Status]    Script Date: 05/07/2022 10:23:09 ******/
ALTER TABLE [dbo].[AdminGrant] ADD  CONSTRAINT [DF_Grant_Status]  DEFAULT ((1)) FOR [Status]
GO
ALTER TABLE [dbo].[lv_user_form] ADD  CONSTRAINT [DF_lv_user_form_To_Type]  DEFAULT ((0)) FOR [To_Type]
GO