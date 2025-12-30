/****** Object:  Table [dbo].[lv_chater_domain]    Script Date: 06/10/2021 11:28:29 ******/
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

ALTER TABLE [dbo].[lv_chater_domain] ADD  CONSTRAINT [DF_lv_chater_domain_GroupId]  DEFAULT ((0)) FOR [GroupId]
GO

ALTER TABLE [dbo].[lv_chater_domain] ADD  CONSTRAINT [DF_lv_chater_domain_Status]  DEFAULT ((0)) FOR [Status]
GO

ALTER TABLE [dbo].[lv_chater_domain] ADD  CONSTRAINT [DF_lv_chater_domain_Ord]  DEFAULT ((0)) FOR [Ord]
GO

ALTER TABLE [dbo].[lv_chater_domain] ADD  CONSTRAINT [DF_lv_chater_domain_CreateTime]  DEFAULT (getdate()) FOR [CreateTime]
GO

/****** Object:  Table [dbo].[lv_chater_wechat]    Script Date: 06/10/2021 11:29:22 ******/
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

ALTER TABLE [dbo].[lv_chater_wechat] ADD  CONSTRAINT [DF_lv_chater_wechat_GroupId]  DEFAULT ((0)) FOR [GroupId]
GO

ALTER TABLE [dbo].[lv_chater_wechat] ADD  CONSTRAINT [DF_lv_chater_wechat_subscribe]  DEFAULT ((0)) FOR [subscribe]
GO

ALTER TABLE [dbo].[lv_chater_wechat] ADD  CONSTRAINT [DF_lv_chater_wechat_Status]  DEFAULT ((0)) FOR [Status]
GO

ALTER TABLE [dbo].[lv_chater_wechat] ADD  CONSTRAINT [DF_lv_chater_wechat_Ord]  DEFAULT ((0)) FOR [Ord]
GO

ALTER TABLE [dbo].[lv_chater_wechat] ADD  CONSTRAINT [DF_lv_chater_wechat_CreateTime]  DEFAULT (getdate()) FOR [CreateTime]
GO


SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

ALTER TABLE [dbo].[lv_user] ADD [Chater] [nvarchar](50) NULL
GO