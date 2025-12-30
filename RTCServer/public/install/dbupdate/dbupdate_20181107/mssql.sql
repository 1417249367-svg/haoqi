/****** Object:  Table [dbo].[Tab_Meet_Msg_XXX]    Script Date: 11/08/2018 01:28:38 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Tab_Meet_Msg_XXX](
	[Col_MeetID] [varchar](38) NOT NULL,
	[Col_MsgID] [varchar](38) NOT NULL,
	[Col_SendLogin] [varchar](80) NOT NULL,
	[Col_SendName] [varchar](50) NOT NULL,
	[Col_Date] [datetime] NOT NULL,
	[Col_Content] [varchar](512) NOT NULL,
	[Col_ContentType] [varchar](50) NOT NULL,
	[Col_DataPath] [varchar](50) NOT NULL,
 CONSTRAINT [PK_Tab_Meet_Msg_XXX] PRIMARY KEY CLUSTERED 
(
	[Col_MeetID] ASC,
	[Col_MsgID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Tab_Meet_Member]    Script Date: 11/08/2018 01:28:38 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Tab_Meet_Member](
	[Col_MeetID] [varchar](38) NOT NULL,
	[Col_UserLogin] [varchar](80) NULL,
	[Col_UserName] [varchar](50) NULL,
	[Col_UserID] [int] NOT NULL,
	[Col_JoinState] [smallint] NULL,
	[Col_JoinTime] [datetime] NULL,
	[Col_IsAdmin] [int] NULL,
	[Col_LastMsgTime] [datetime] NULL,
	[Col_socketId] [varchar](200) NULL,
	[Col_LoginType] [smallint] NULL,
	[Col_IsAudio] [smallint] NULL,
	[Col_IsVideo] [smallint] NULL,
	[Col_State] [smallint] NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Tab_Meet_File_Group]    Script Date: 11/08/2018 01:28:38 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Tab_Meet_File_Group](
	[Col_MeetID] [varchar](38) NOT NULL,
	[Col_Name] [varchar](80) NOT NULL,
 CONSTRAINT [PK_Tab_Meet_File_Group] PRIMARY KEY CLUSTERED 
(
	[Col_MeetID] ASC,
	[Col_Name] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Tab_Meet_File]    Script Date: 11/08/2018 01:28:38 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Tab_Meet_File](
	[Col_MeetID] [varchar](38) NOT NULL,
	[Col_FileID] [varchar](38) NOT NULL,
	[Col_FileName] [varchar](255) NOT NULL,
	[Col_FileSize] [bigint] NOT NULL,
	[Col_FileSName] [varchar](50) NOT NULL,
	[Col_FileType] [smallint] NOT NULL,
	[Col_SendLogin] [varchar](80) NOT NULL,
	[Col_SendName] [varchar](50) NOT NULL,
	[Col_SendDate] [datetime] NOT NULL,
	[Col_DownCount] [int] NULL,
	[Col_Group] [varchar](80) NULL,
 CONSTRAINT [PK_Tab_Meet_File] PRIMARY KEY CLUSTERED 
(
	[Col_MeetID] ASC,
	[Col_FileID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[Tab_Meet]    Script Date: 11/08/2018 01:28:38 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[Tab_Meet](
	[Col_ID] [varchar](38) NOT NULL,
	[Col_Name] [varchar](50) NOT NULL,
	[Col_Desc] [varchar](128) NULL,
	[Col_Notice] [varchar](255) NULL,
	[Col_CreateLogin] [varchar](80) NULL,
	[Col_CreateName] [varchar](50) NULL,
	[Col_CreateID] [int] NULL,
	[Col_CreateDate] [datetime] NULL,
	[Col_IsDelete] [bit] NULL,
	[Col_Type] [smallint] NULL,
	[Col_JoinVerify] [smallint] NULL,
	[Col_Genre] [varchar](50) NULL,
	[Col_UserCount] [smallint] NULL,
	[Col_MsgIndex] [smallint] NULL,
	[Col_DomainID] [varchar](50) NULL,
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
/****** Object:  Table [dbo].[Tab_Chat]    Script Date: 11/08/2018 01:28:38 ******/
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
	[socketId] [varchar](200) NULL,
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

/****** Object:  Default [DF_Tab_Chat_GroupId]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_GroupId]  DEFAULT ((0)) FOR [GroupId]
GO
/****** Object:  Default [DF_Tab_Chat_UserId]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_UserId]  DEFAULT ((0)) FOR [YouID]
GO
/****** Object:  Default [DF_Tab_Chat_ConnectTime]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_ConnectTime]  DEFAULT (getdate()) FOR [ConnectTime]
GO
/****** Object:  Default [DF_Tab_Chat_Col_IsAudio]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_Col_IsAudio]  DEFAULT ((0)) FOR [IsAudio]
GO
/****** Object:  Default [DF_Tab_Chat_Col_IsVideo]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_Col_IsVideo]  DEFAULT ((0)) FOR [IsVideo]
GO
/****** Object:  Default [DF_Tab_Chat_LoginType]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_LoginType]  DEFAULT ((1)) FOR [LoginType1]
GO
/****** Object:  Default [DF_Tab_Chat_LoginType2]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_LoginType2]  DEFAULT ((1)) FOR [LoginType2]
GO
/****** Object:  Default [DF_Tab_Chat_IsAudio1]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_IsAudio1]  DEFAULT ((0)) FOR [IsAudio1]
GO
/****** Object:  Default [DF_Tab_Chat_IsVideo1]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_IsVideo1]  DEFAULT ((0)) FOR [IsVideo1]
GO
/****** Object:  Default [DF_Tab_Chat_IsAudio2]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_IsAudio2]  DEFAULT ((0)) FOR [IsAudio2]
GO
/****** Object:  Default [DF_Tab_Chat_IsVideo2]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_IsVideo2]  DEFAULT ((0)) FOR [IsVideo2]
GO
/****** Object:  Default [DF_Tab_Chat_Status]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_Status]  DEFAULT ((0)) FOR [Status]
GO
/****** Object:  Default [DF_Tab_Chat_CloseRole]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_CloseRole]  DEFAULT ((0)) FOR [CloseRole]
GO
/****** Object:  Default [DF_Tab_Chat_Rate]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_Rate]  DEFAULT ((0)) FOR [Rate]
GO
/****** Object:  Default [DF_Tab_Chat_AllowUploadFile]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_AllowUploadFile]  DEFAULT ((0)) FOR [AllowUploadFile]
GO
/****** Object:  Default [DF_Tab_Chat_Ord]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Chat] ADD  CONSTRAINT [DF_Tab_Chat_Ord]  DEFAULT ((0)) FOR [Ord]
GO
/****** Object:  Default [DF_Tab_Meet_Col_Name]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_Name]  DEFAULT ('') FOR [Col_Name]
GO
/****** Object:  Default [DF_Tab_Meet_Col_Desc]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_Desc]  DEFAULT ('') FOR [Col_Desc]
GO
/****** Object:  Default [DF_Tab_Meet_Col_Notice]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_Notice]  DEFAULT ('') FOR [Col_Notice]
GO
/****** Object:  Default [DF_Tab_Meet_Col_CreateLogin]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_CreateLogin]  DEFAULT ('') FOR [Col_CreateLogin]
GO
/****** Object:  Default [DF_Tab_Meet_Col_CreateName]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_CreateName]  DEFAULT ('') FOR [Col_CreateName]
GO
/****** Object:  Default [DF_Tab_Meet_Col_CreateID]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_CreateID]  DEFAULT ((0)) FOR [Col_CreateID]
GO
/****** Object:  Default [DF_Tab_Meet_Col_CreateDate]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_CreateDate]  DEFAULT (getdate()) FOR [Col_CreateDate]
GO
/****** Object:  Default [DF_Tab_Meet_Col_IsDelete]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_IsDelete]  DEFAULT ((0)) FOR [Col_IsDelete]
GO
/****** Object:  Default [DF_Tab_Meet_Col_Type]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_Type]  DEFAULT ((0)) FOR [Col_Type]
GO
/****** Object:  Default [DF_Tab_Meet_Col_JoinVerify]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_JoinVerify]  DEFAULT ((0)) FOR [Col_JoinVerify]
GO
/****** Object:  Default [DF_Tab_Meet_Col_Genre]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_Genre]  DEFAULT ('') FOR [Col_Genre]
GO
/****** Object:  Default [DF_Tab_Meet_Col_UserCount]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_UserCount]  DEFAULT ((200)) FOR [Col_UserCount]
GO
/****** Object:  Default [DF_Tab_Meet_Col_MsgIndex]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_MsgIndex]  DEFAULT ((0)) FOR [Col_MsgIndex]
GO
/****** Object:  Default [DF_Tab_Meet_Col_DomainID]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_DomainID]  DEFAULT ('') FOR [Col_DomainID]
GO
/****** Object:  Default [DF_Tab_Meet_Col_IsAudio]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_IsAudio]  DEFAULT ((0)) FOR [Col_IsAudio]
GO
/****** Object:  Default [DF_Tab_Meet_Col_IsVideo]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_IsVideo]  DEFAULT ((0)) FOR [Col_IsVideo]
GO
/****** Object:  Default [DF_Tab_Meet_Col_State]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_State]  DEFAULT ((0)) FOR [Col_State]
GO
/****** Object:  Default [DF_Tab_Meet_Col_SchDate]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet] ADD  CONSTRAINT [DF_Tab_Meet_Col_SchDate]  DEFAULT ('1900-01-01 00:00:00') FOR [Col_SchDate]
GO
/****** Object:  Default [DF_Tab_Meet_File_Col_FileName]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet_File] ADD  CONSTRAINT [DF_Tab_Meet_File_Col_FileName]  DEFAULT ('') FOR [Col_FileName]
GO
/****** Object:  Default [DF_Tab_Meet_File_Col_FileSize]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet_File] ADD  CONSTRAINT [DF_Tab_Meet_File_Col_FileSize]  DEFAULT ((0)) FOR [Col_FileSize]
GO
/****** Object:  Default [DF_Tab_Meet_File_Col_FileSName]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet_File] ADD  CONSTRAINT [DF_Tab_Meet_File_Col_FileSName]  DEFAULT ('') FOR [Col_FileSName]
GO
/****** Object:  Default [DF_Tab_Meet_File_Col_FileType]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet_File] ADD  CONSTRAINT [DF_Tab_Meet_File_Col_FileType]  DEFAULT ((0)) FOR [Col_FileType]
GO
/****** Object:  Default [DF_Tab_Meet_File_Col_SendLogin]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet_File] ADD  CONSTRAINT [DF_Tab_Meet_File_Col_SendLogin]  DEFAULT ('') FOR [Col_SendLogin]
GO
/****** Object:  Default [DF_Tab_Meet_File_Col_SendName]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet_File] ADD  CONSTRAINT [DF_Tab_Meet_File_Col_SendName]  DEFAULT ('') FOR [Col_SendName]
GO
/****** Object:  Default [DF_Tab_Meet_File_Col_SendDate]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet_File] ADD  CONSTRAINT [DF_Tab_Meet_File_Col_SendDate]  DEFAULT (getdate()) FOR [Col_SendDate]
GO
/****** Object:  Default [DF_Tab_Meet_File_Col_DownCount]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet_File] ADD  CONSTRAINT [DF_Tab_Meet_File_Col_DownCount]  DEFAULT ((0)) FOR [Col_DownCount]
GO
/****** Object:  Default [DF_Tab_Meet_File_Col_Group]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet_File] ADD  CONSTRAINT [DF_Tab_Meet_File_Col_Group]  DEFAULT ('') FOR [Col_Group]
GO
/****** Object:  Default [DF_Tab_Meet_Member_Col_UserLogin]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet_Member] ADD  CONSTRAINT [DF_Tab_Meet_Member_Col_UserLogin]  DEFAULT ('') FOR [Col_UserLogin]
GO
/****** Object:  Default [DF_Tab_Meet_Member_Col_UserName]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet_Member] ADD  CONSTRAINT [DF_Tab_Meet_Member_Col_UserName]  DEFAULT ('') FOR [Col_UserName]
GO
/****** Object:  Default [DF_Tab_Meet_Member_Col_UserID]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet_Member] ADD  CONSTRAINT [DF_Tab_Meet_Member_Col_UserID]  DEFAULT ((0)) FOR [Col_UserID]
GO
/****** Object:  Default [DF_Tab_Meet_Member_Col_JoinState]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet_Member] ADD  CONSTRAINT [DF_Tab_Meet_Member_Col_JoinState]  DEFAULT ((0)) FOR [Col_JoinState]
GO
/****** Object:  Default [DF_Tab_Meet_Member_Col_JoinTime]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet_Member] ADD  CONSTRAINT [DF_Tab_Meet_Member_Col_JoinTime]  DEFAULT ('1900-01-01 00:00:00') FOR [Col_JoinTime]
GO
/****** Object:  Default [DF_Tab_Meet_Member_Col_IsAdmin]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet_Member] ADD  CONSTRAINT [DF_Tab_Meet_Member_Col_IsAdmin]  DEFAULT ((0)) FOR [Col_IsAdmin]
GO
/****** Object:  Default [DF_Tab_Meet_Member_Col_LastMsgTime]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet_Member] ADD  CONSTRAINT [DF_Tab_Meet_Member_Col_LastMsgTime]  DEFAULT ('1900-01-01 00:00:00') FOR [Col_LastMsgTime]
GO
/****** Object:  Default [DF_Tab_Meet_Member_Col_LoginType]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet_Member] ADD  CONSTRAINT [DF_Tab_Meet_Member_Col_LoginType]  DEFAULT ((1)) FOR [Col_LoginType]
GO
/****** Object:  Default [DF_Tab_Meet_Member_Col_IsAudio]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet_Member] ADD  CONSTRAINT [DF_Tab_Meet_Member_Col_IsAudio]  DEFAULT ((0)) FOR [Col_IsAudio]
GO
/****** Object:  Default [DF_Tab_Meet_Member_Col_IsVideo]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet_Member] ADD  CONSTRAINT [DF_Tab_Meet_Member_Col_IsVideo]  DEFAULT ((0)) FOR [Col_IsVideo]
GO
/****** Object:  Default [DF_Tab_Meet_Member_Col_State]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet_Member] ADD  CONSTRAINT [DF_Tab_Meet_Member_Col_State]  DEFAULT ((0)) FOR [Col_State]
GO
/****** Object:  Default [DF_Tab_Meet_Msg_XXX_Col_SendLogin]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet_Msg_XXX] ADD  CONSTRAINT [DF_Tab_Meet_Msg_XXX_Col_SendLogin]  DEFAULT ('') FOR [Col_SendLogin]
GO
/****** Object:  Default [DF_Tab_Meet_Msg_XXX_Col_SendName]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet_Msg_XXX] ADD  CONSTRAINT [DF_Tab_Meet_Msg_XXX_Col_SendName]  DEFAULT ('') FOR [Col_SendName]
GO
/****** Object:  Default [DF_Tab_Meet_Msg_XXX_Col_Date]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet_Msg_XXX] ADD  CONSTRAINT [DF_Tab_Meet_Msg_XXX_Col_Date]  DEFAULT (getdate()) FOR [Col_Date]
GO
/****** Object:  Default [DF_Tab_Meet_Msg_XXX_Col_Content]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet_Msg_XXX] ADD  CONSTRAINT [DF_Tab_Meet_Msg_XXX_Col_Content]  DEFAULT ('') FOR [Col_Content]
GO
/****** Object:  Default [DF_Tab_Meet_Msg_XXX_Col_ContentType]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet_Msg_XXX] ADD  CONSTRAINT [DF_Tab_Meet_Msg_XXX_Col_ContentType]  DEFAULT ('') FOR [Col_ContentType]
GO
/****** Object:  Default [DF_Tab_Meet_Msg_XXX_Col_DataPath]    Script Date: 11/08/2018 01:28:38 ******/
ALTER TABLE [dbo].[Tab_Meet_Msg_XXX] ADD  CONSTRAINT [DF_Tab_Meet_Msg_XXX_Col_DataPath]  DEFAULT ('') FOR [Col_DataPath]
GO

ALTER TABLE [dbo].[PtpFolder] ADD  [To_Type] [smallint] NULL
GO
ALTER TABLE [dbo].[PtpFolder] ADD  [CreatorID] [varchar](50) NULL
GO
ALTER TABLE [dbo].[PtpFolder] ADD  [CreatorName] [varchar](200) NULL
GO
ALTER TABLE [dbo].[PtpFolder] ADD  CONSTRAINT [DF_PtpFolder_To_Type]  DEFAULT ((3)) FOR [To_Type]
GO
ALTER TABLE [dbo].[PtpFolder] ADD  CONSTRAINT [DF_PtpFolder_CreatorID]  DEFAULT ((1)) FOR [CreatorID]
GO
ALTER TABLE [dbo].[PtpFolder] ADD  CONSTRAINT [DF_PtpFolder_CreatorName]  DEFAULT ('admin') FOR [CreatorName]
GO

ALTER TABLE [dbo].[PtpFile] ADD  [To_Type] [smallint] NULL
GO
ALTER TABLE [dbo].[PtpFile] ADD  [CreatorID] [varchar](50) NULL
GO
ALTER TABLE [dbo].[PtpFile] ADD  [CreatorName] [varchar](200) NULL
GO

ALTER TABLE [dbo].[PtpFile] ADD  CONSTRAINT [DF_PtpFile_CreatorID]  DEFAULT ((1)) FOR [CreatorID]
GO
ALTER TABLE [dbo].[PtpFile] ADD  CONSTRAINT [DF_PtpFile_CreatorName]  DEFAULT ('admin') FOR [CreatorName]
GO

update PtpFolder set To_Type=3,CreatorID=MyID where MyID<>'Public'
update PtpFolder set To_Type=1,CreatorID=1,CreatorName='admin' where MyID='Public'
update PtpFolder set ParentID='0' where ParentID='00000000'

update PtpFile set To_Type=3,CreatorID=MyID where MyID<>'Public'
update PtpFile set To_Type=1,CreatorID=1,CreatorName='admin' where MyID='Public'

execute sp_rename 'PtpFolder.PtpFolderID','PtpFolderID1'
execute sp_rename 'PtpFolder.ID','PtpFolderID'

/****** Object:  Table [dbo].[Plug]    Script Date: 08/01/2018 21:47:30 ******/
SET IDENTITY_INSERT [dbo].[Plug] ON
INSERT [dbo].[Plug] ([Plug_ID], [Plug_Name], [Plug_Site], [Plug_Height], [Plug_Width], [Plug_TargetType], [Plug_Target], [Plug_DisplayName], [Plug_Desc], [Plug_Param], [Plug_Image], [Plug_Enabled], [Plug_Index], [Plug_Bie]) VALUES (20, N'Meeting', N'12', N'600', N'1000', N'1', N'', N'实时音视频', N'实时音视频', N'https://webrtc.qiyeim.com', N'', 1, 2, 0)
SET IDENTITY_INSERT [dbo].[Plug] OFF