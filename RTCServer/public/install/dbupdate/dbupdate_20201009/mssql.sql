/****** Object:  Table [dbo].[lv_transfer]    Script Date: 10/09/2020 23:19:15 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[lv_transfer](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[ChatId] [int] NULL,
	[MyID] [varchar](50) NULL,
	[YouID] [varchar](50) NULL,
	[Chater] [nvarchar](50) NULL,
	[To_Type] [int] NULL,
	[Todate] [datetime] NULL,
 CONSTRAINT [PK_lv_transfer] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO

ALTER TABLE [dbo].[lv_transfer] ADD  CONSTRAINT [DF_lv_transfer_To_Type]  DEFAULT ((1)) FOR [To_Type]
GO

ALTER TABLE [dbo].[lv_transfer] ADD  CONSTRAINT [DF_lv_transfer_Todate]  DEFAULT (getdate()) FOR [Todate]
GO

ALTER TABLE [dbo].[lv_chater_ro] ADD [WelCome] [nvarchar](500) NULL
GO