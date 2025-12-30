SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

ALTER TABLE [dbo].[Clot_Ro] ADD  [Disk_Space] [varchar](50) NULL
GO

ALTER TABLE [dbo].[Clot_Ro] ADD  CONSTRAINT [DF_Clot_Ro_Disk_Space]  DEFAULT ((1024)) FOR [Disk_Space]
GO

ALTER TABLE [dbo].[Clot_Form] ADD  [IsAdmin] [tinyint] NULL
GO

/****** Object:  Table [dbo].[lv_question]    Script Date: 02/23/2020 17:06:02 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[lv_question](
	[QuestionId] [int] NOT NULL,
	[Chater] [nvarchar](50) NULL,
	[Subject] [nvarchar](255) NULL,
	[UserText] [varchar](max) NULL,
	[To_Type] [smallint] NULL,
	[Ord] [int] NULL,
	[CreateTime] [datetime] NOT NULL,
 CONSTRAINT [PK_lv_question] PRIMARY KEY CLUSTERED 
(
	[QuestionId] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO

ALTER TABLE [dbo].[lv_question] ADD  CONSTRAINT [DF_lv_question_QuestionId]  DEFAULT ((0)) FOR [QuestionId]
GO
ALTER TABLE [dbo].[lv_question] ADD  CONSTRAINT [DF_lv_question_To_Type]  DEFAULT ((0)) FOR [To_Type]
GO
ALTER TABLE [dbo].[lv_question] ADD  CONSTRAINT [DF_lv_question_Ord]  DEFAULT ((0)) FOR [Ord]
GO
ALTER TABLE [dbo].[lv_question] ADD  CONSTRAINT [DF_lv_question_CreateTime]  DEFAULT (getdate()) FOR [CreateTime]
GO

update Clot_Form set IsAdmin=Admin
update Clot_Ro set Disk_Space=DiskSpace