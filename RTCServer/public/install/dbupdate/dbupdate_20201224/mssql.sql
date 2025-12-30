SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO


ALTER TABLE [dbo].[lv_message] ALTER COLUMN [GroupId] [int] NULL
GO
ALTER TABLE [dbo].[lv_message] ALTER COLUMN [Chater] [nvarchar](50) NULL
GO

ALTER TABLE [dbo].[lv_message] ADD  CONSTRAINT [DF_lv_message_GroupId]  DEFAULT ((0)) FOR [GroupId]
GO