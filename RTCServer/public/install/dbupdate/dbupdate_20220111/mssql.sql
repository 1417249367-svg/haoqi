SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

ALTER TABLE [dbo].[lv_user] ADD [maxTypeID] [int] NULL
GO
ALTER TABLE [dbo].[lv_user] ADD [myChater] [nvarchar](50) NULL
GO

ALTER TABLE [dbo].[lv_user] ADD  CONSTRAINT [DF_lv_user_maxTypeID]  DEFAULT ((0)) FOR [maxTypeID]
GO

ALTER TABLE [dbo].[lv_question] ADD [col_match] [smallint] NULL
GO
ALTER TABLE [dbo].[lv_question] ADD [col_receive] [smallint] NULL
GO
ALTER TABLE [dbo].[lv_question] ADD [col_top] [smallint] NULL
GO

ALTER TABLE [dbo].[lv_question] ADD  CONSTRAINT [DF_lv_question_col_match]  DEFAULT ((0)) FOR [col_match]
GO
ALTER TABLE [dbo].[lv_question] ADD  CONSTRAINT [DF_lv_question_col_receive]  DEFAULT ((0)) FOR [col_receive]
GO
ALTER TABLE [dbo].[lv_question] ADD  CONSTRAINT [DF_lv_question_col_top]  DEFAULT ((0)) FOR [col_top]
GO

ALTER TABLE [dbo].[Tab_Config] ALTER COLUMN [Col_Data] [varchar](8000) NULL
GO

update lv_question set col_match=0
update lv_question set col_receive=0
update lv_question set col_top=1