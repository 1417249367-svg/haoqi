/****** Object:  Table [dbo].[remote_chat]    Script Date: 07/05/2019 00:11:18 ******/
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

ALTER TABLE [dbo].[remote_chat] ADD  CONSTRAINT [DF_remote_chat_GroupId]  DEFAULT ((0)) FOR [GroupId]
GO

ALTER TABLE [dbo].[remote_chat] ADD  CONSTRAINT [DF_remote_chat_UserId]  DEFAULT ((0)) FOR [YouID]
GO

ALTER TABLE [dbo].[remote_chat] ADD  CONSTRAINT [DF_remote_chat_ConnectTime]  DEFAULT (getdate()) FOR [ConnectTime]
GO

ALTER TABLE [dbo].[remote_chat] ADD  CONSTRAINT [DF_remote_chat_Status]  DEFAULT ((0)) FOR [Status]
GO

ALTER TABLE [dbo].[remote_chat] ADD  CONSTRAINT [DF_remote_chat_CloseRole]  DEFAULT ((0)) FOR [CloseRole]
GO

ALTER TABLE [dbo].[remote_chat] ADD  CONSTRAINT [DF_remote_chat_Rate]  DEFAULT ((0)) FOR [Rate]
GO

ALTER TABLE [dbo].[remote_chat] ADD  CONSTRAINT [DF_remote_chat_AllowUploadFile]  DEFAULT ((0)) FOR [AllowUploadFile]
GO

ALTER TABLE [dbo].[remote_chat] ADD  CONSTRAINT [DF_remote_chat_Ord]  DEFAULT ((0)) FOR [Ord]
GO