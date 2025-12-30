

var fs = require('fs');
//var ini = require('ini');
//var Info = ini.parse (fs .readFileSync ('./public/Data/DataBase.ini','utf-8'));
var db = {};
if(Info["server_connection"].DB_TYPE=="mssql") {
    var mssql = require('mssql');
    var config = {
        user: Info["server_connection"].DB_USER,
        password: Info["server_connection"].DB_PWD,
        server: Info["server_connection"].DB_SERVER,
        database: Info["server_connection"].DB_NAME,
        multipleStatements: true,
        port: Info["server_connection"].DB_PORT
    }
    // var query = function(strsql) {
    //     return new Promise(function(resolve, reject){
    //         mssql.connect(config).then(function() {
    //             var req = new mssql.Request().query(strsql).then(function(recordset) {
    //                 resolve(recordset);
    //             }).
    //             catch(function(err) {
    //                 reject(err);
    //             });
    //         }).
    //         catch(function(err) {
    //             reject(err);
    //         });
    //     })
    // };
    var query = function (sql, callBack) {
        var connection = new mssql.ConnectionPool(config, function (err) {
            if (err) {
                console.log(err);
                return;
            }
            var ps = new mssql.PreparedStatement(connection);
            ps.prepare(sql, function (err) {
                if (err) {
                    console.log(err);
                    return;
                }
                ps.execute('', function (err, result) {
                    if (err) {
                        console.log(err);
                        return;
                    }
                    ps.unprepare(function (err) {
                        if (err) {
                            console.log(err);
                            callback(err, null);
                            mssql.close();
                            return;
                        }
                        if (result.recordset) {
                            for (var j = 0; j < result.recordset.length; j++) {
                                var newObj = upperJSONKey(result.recordset[j]);
                                result.recordset[j] = newObj;
                            }
                        }
                        callBack(err, result);
                        mssql.close();
                    });
                });
            });
        })

    };
}else{
    var dmdb = require('oracledb');
    var config = {
        user:Info["server_connection"].DB_USER,　　//用户名
        password:Info["server_connection"].DB_PWD,　　//密码  //IP:数据库IP地址，PORT:数据库端口，SCHEMA:数据库名称
        connectString : Info["server_connection"].DB_SERVER+":"+Info["server_connection"].DB_PORT
    };
    var query = function(sql,callback){
        dmdb.getConnection(
            config,
            function (err, connection)
            {
                if (err)
                {
                    console.error(err.message);
                    return;
                }/*else{
                console.log("连接成功");
            }*/
                connection.execute(sql, [], function (err, result)
                {
                    if (err)
                    {
                        console.error(err.message);
                        //doRelease(connection);
                        return;
                    }
                    //console.log(result);
                    if(result.hasOwnProperty("rowsAffected")){
                        connection.commit();
                        callback(err, result);
                        return;
                    }
                    for(var j=0;j<result.metaData.length;j++){
                        result.metaData[j].name=result.metaData[j].name.toLowerCase();
                    }

                    result.rows=result.rows.map((v)=>
                    {
                        return result.metaData.reduce((p, key, i)=>
                        {
                            p[key.name] = v[i];
                            return p;
                        }, {})
                    });

                    var data={recordset: result.rows,
                        output: {},
                        rowsAffected: [ result.rows.length ],
                        returnValue: 0 };

                    //console.log(result.metaData);
                    callback(err, data);
                    //doRelease(connection);
                });
            }
        );
    }

}

function upperJSONKey(jsonObj){
    for (var key in jsonObj){
        jsonObj[key.toLowerCase()] = jsonObj[key];
        //delete(jsonObj[key]);
    }
    return jsonObj;
}

// function doRelease(connection) {
//     connection.close(
//         function(err) {
//             if (err)
//                 console.error(err.message);
//         });
// }
function doRelease(connection) {
    connection.release(
        function(err) {
            if (err) {console.error(err.message);}
        }
    );
}
exports.query = query;