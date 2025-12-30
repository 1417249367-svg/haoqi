/****** Object:  Table [dbo].[rtc_keyword]    Script Date: 01/10/2019 21:38:23 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

ALTER TABLE [dbo].[Users_ID] ALTER  column  [Registration_Id] [varchar](200) NULL
GO

ALTER TABLE [dbo].[OnlineFile] ADD  [FormFileType] [smallint] NULL
GO

ALTER TABLE [dbo].[OnlineFile] ADD  CONSTRAINT [DF_OnlineFile_To_Type]  DEFAULT ((7)) FOR [FormFileType]
GO

ALTER TABLE [dbo].[PtpFile] ADD  [OnlineID] [int] NULL
GO

ALTER TABLE [dbo].[PtpFile] ADD  CONSTRAINT [DF_PtpFile_OnlineID]  DEFAULT ((0)) FOR [OnlineID]
GO

ALTER TABLE [dbo].[LeaveFile] ADD  [OnlineID] [int] NULL
GO

ALTER TABLE [dbo].[LeaveFile] ADD  CONSTRAINT [DF_LeaveFile_OnlineID]  DEFAULT ((0)) FOR [OnlineID]
GO

ALTER TABLE [dbo].[ClotFile] ADD  [OnlineID] [int] NULL
GO

ALTER TABLE [dbo].[ClotFile] ADD  CONSTRAINT [DF_ClotFile_OnlineID]  DEFAULT ((0)) FOR [OnlineID]
GO

update OnlineFile set FormFileType=7
update PtpFile set OnlineID=0
update LeaveFile set OnlineID=0
update ClotFile set OnlineID=0