SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

ALTER TABLE [dbo].[lv_user] ADD  [UserIcoLine] [tinyint] NULL
GO

ALTER TABLE [dbo].[lv_user] ADD  [Status] [int] NULL
GO

ALTER TABLE [dbo].[lv_user] ADD  [IsWeb] [tinyint] NULL
GO

ALTER TABLE [dbo].[lv_chat] ADD  [ThemeId] [int] NULL
GO

ALTER TABLE [dbo].[lv_chat] ADD  [ChatLevel] [int] NULL
GO

ALTER TABLE [dbo].[lv_chat] ADD  [IsEnable] [int] NULL
GO

ALTER TABLE [dbo].[Clot_Silence] ADD  [Ncontent] [varchar](max) NULL
GO

/****** Object:  Table [dbo].[lv_chater_theme]    Script Date: 08/14/2020 23:02:58 ******/
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

/****** Object:  Default [DF_lv_chater_theme_GroupId]    Script Date: 08/14/2020 23:02:58 ******/
ALTER TABLE [dbo].[lv_chater_theme] ADD  CONSTRAINT [DF_lv_chater_theme_GroupId]  DEFAULT ((0)) FOR [GroupId]
GO
/****** Object:  Default [DF_lv_chater_theme_Status]    Script Date: 08/14/2020 23:02:58 ******/
ALTER TABLE [dbo].[lv_chater_theme] ADD  CONSTRAINT [DF_lv_chater_theme_Status]  DEFAULT ((0)) FOR [Status]
GO
/****** Object:  Default [DF_lv_chater_theme_Ord]    Script Date: 08/14/2020 23:02:58 ******/
ALTER TABLE [dbo].[lv_chater_theme] ADD  CONSTRAINT [DF_lv_chater_theme_Ord]  DEFAULT ((0)) FOR [Ord]
GO
/****** Object:  Default [DF_lv_chater_theme_CreateTime]    Script Date: 08/14/2020 23:02:58 ******/
ALTER TABLE [dbo].[lv_chater_theme] ADD  CONSTRAINT [DF_lv_chater_theme_CreateTime]  DEFAULT (getdate()) FOR [CreateTime]
GO

/****** Object:  Default [DF_lv_user_UserIcoLine]    Script Date: 08/14/2020 23:02:58 ******/
ALTER TABLE [dbo].[lv_user] ADD  CONSTRAINT [DF_lv_user_UserIcoLine]  DEFAULT ((0)) FOR [UserIcoLine]
GO
/****** Object:  Default [DF_lv_user_Status]    Script Date: 08/14/2020 23:02:58 ******/
ALTER TABLE [dbo].[lv_user] ADD  CONSTRAINT [DF_lv_user_Status]  DEFAULT ((0)) FOR [Status]
GO
/****** Object:  Default [DF_lv_user_IsWeb]    Script Date: 08/14/2020 23:02:58 ******/
ALTER TABLE [dbo].[lv_user] ADD  CONSTRAINT [DF_lv_user_IsWeb]  DEFAULT ((0)) FOR [IsWeb]
GO


/****** Object:  Default [DF_lv_chat_ThemeId]    Script Date: 08/14/2020 23:02:58 ******/
ALTER TABLE [dbo].[lv_chat] ADD  CONSTRAINT [DF_lv_chat_ThemeId]  DEFAULT ((0)) FOR [ThemeId]
GO
/****** Object:  Default [DF_lv_chat_ChatLevel]    Script Date: 08/14/2020 23:02:58 ******/
ALTER TABLE [dbo].[lv_chat] ADD  CONSTRAINT [DF_lv_chat_ChatLevel]  DEFAULT ((0)) FOR [ChatLevel]
GO
/****** Object:  Default [DF_lv_chat_IsEnable]    Script Date: 08/14/2020 23:02:58 ******/
ALTER TABLE [dbo].[lv_chat] ADD  CONSTRAINT [DF_lv_chat_IsEnable]  DEFAULT ((0)) FOR [IsEnable]
GO

SET IDENTITY_INSERT [dbo].[lv_chater_theme] ON
INSERT [dbo].[lv_chater_theme] ([TypeID], [GroupId], [TypeName], [Description], [Status], [Ord], [CreateTime]) VALUES (7, 0, N'咨询', N'咨询', 1, 1000, CAST(0x0000AC17016C8AC0 AS DateTime))
INSERT [dbo].[lv_chater_theme] ([TypeID], [GroupId], [TypeName], [Description], [Status], [Ord], [CreateTime]) VALUES (8, 0, N'投诉', N'投诉', 1, 1000, CAST(0x0000AC17016C94A4 AS DateTime))
SET IDENTITY_INSERT [dbo].[lv_chater_theme] OFF

update lv_user set UserIcoLine=0
update lv_user set Status=0
update lv_user set IsWeb=0

update lv_chat set ThemeId=0
update lv_chat set ChatLevel=0
update lv_chat set IsEnable=1
update lv_chater set Reception=1000