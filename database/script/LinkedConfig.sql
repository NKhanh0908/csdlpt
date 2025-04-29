select * from LINKEDSV2.chdidong.dbo.chinhanh;
	   UNION ALL
select * from LINKEDSV3.chdidong.dbo.chinhanh;

EXEC sp_linkedservers;

-- SERVER 1
EXEC sp_addlinkedserver 
    @server='LINKEDSV2', 
    @srvproduct='', 
    @provider='SQLNCLI', 
    @datasrc='LAPTOP-\';
GO

EXEC sp_addlinkedserver 
    @server='LINKEDSV3', 
    @srvproduct='', 
    @provider='SQLNCLI', 
    @datasrc='LAPTOP-\';
GO

EXEC sp_addlinkedsrvlogin 
    @rmtsrvname='LINKEDSV2', 
    @useself='false', 
    @locallogin=NULL, 
    @rmtuser='sa',      
    @rmtpassword='';
GO

EXEC sp_addlinkedsrvlogin 
    @rmtsrvname='LINKEDSV3', 
    @useself='false', 
    @locallogin=NULL, 
    @rmtuser='sa',       
    @rmtpassword='';
GO

-- Server 2

EXEC sp_addlinkedserver 
    @server='LINKEDSV1', 
    @srvproduct='', 
    @provider='SQLNCLI', 
    @datasrc='LAPTOP-\';
GO

EXEC sp_addlinkedserver 
    @server='LINKEDSV3', 
    @srvproduct='', 
    @provider='SQLNCLI', 
    @datasrc='LAPTOP-\';
GO

EXEC sp_addlinkedsrvlogin 
    @rmtsrvname='LINKEDSV1', 
    @useself='false', 
    @locallogin=NULL, 
    @rmtuser='sa',      
    @rmtpassword='';
GO

EXEC sp_addlinkedsrvlogin 
    @rmtsrvname='LINKEDSV3', 
    @useself='false', 
    @locallogin=NULL, 
    @rmtuser='sa',       
    @rmtpassword='';
GO

-- Server 3
EXEC sp_addlinkedserver 
    @server='LINKEDSV1', 
    @srvproduct='', 
    @provider='SQLNCLI', 
    @datasrc='LAPTOP-\';
GO

EXEC sp_addlinkedserver 
    @server='LINKEDSV2', 
    @srvproduct='', 
    @provider='SQLNCLI', 
    @datasrc='LAPTOP-\';
GO

EXEC sp_addlinkedsrvlogin 
    @rmtsrvname='LINKEDSV1', 
    @useself='false', 
    @locallogin=NULL, 
    @rmtuser='sa',      
    @rmtpassword='';
GO

EXEC sp_addlinkedsrvlogin 
    @rmtsrvname='LINKEDSV2', 
    @useself='false', 
    @locallogin=NULL, 
    @rmtuser='sa',       
    @rmtpassword='';
GO