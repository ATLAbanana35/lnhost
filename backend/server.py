#!/usr/bin/env python3

from http.server import BaseHTTPRequestHandler, HTTPServer
from urllib.parse import parse_qs, urlparse
import datetime
import inspect
import json
import socket
from os import listdir
from os.path import isdir, join
import os
import threading
import subprocess
import requests
import shutil
import sys
api_file = open("../config/server_api.lnc")
api_key = api_file.read()
api_file.close()
apps_path_file = open("../config/app_path.lnc")
app_path = apps_path_file.read().strip()
apps_path_file.close()


def log(data):
    current_time = datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S")
    caller_info = inspect.stack()[1]
    file_name = caller_info[1]
    line_number = caller_info[2]
    calling_function = caller_info[3]
    log_entry = (
        f"{current_time} - {file_name}:{line_number} ({calling_function}): {data}"
    )
    with open("../logs/log.txt", "a") as f:
        f.write(log_entry + "\n")


class MyServer(BaseHTTPRequestHandler):
    def do_GET(self):
        try:
            if not isdir("/home/"+os.getenv("USER")+"/mysql"):
                os.system("cp /lnhost/data/mysql-8.3.0-linux-glibc2.28-x86_64.tar.xz ../scripts/mysql-8.3.0-linux-glibc2.28-x86_64.tar.xz")
            if self.path.split("?")[0] == "/run_nextcloud_setup":
                os.system("cp /lnhost/data/nc-latest.zip ../scripts/nc-latest.zip")
                client_ip = self.client_address[0]
                self.send_response(200)
                self.send_header("Content-type", "text/html")
                self.send_header("Access-Control-Allow-Origin", "*")
                self.end_headers()

                # Extraire le mot de passe de la requête GET
                query_components = parse_qs(urlparse(self.path).query)
                bdd_password = query_components.get("db_password", [""])[0]
                log(str(client_ip) + " is Asking nextcloud SETUP.")
                nextcloud_exists = os.path.exists("/home/"+os.getenv("USER")+"/apps/nextcloud")
                response = ""
                UserWhoRunTheScript = os.getenv("USER")
                f = open("../config/tmp_api.verify")
                tmp = f.read()
                f.close()
                if query_components.get("tmp_api_key", [""])[0] == tmp:
                    if not nextcloud_exists:
                        log("Executing setup_nextcloud command." + UserWhoRunTheScript)

                        def after(args):
                            def r(args):
                                pass

                            self.run_script_in_background(
                                "../scripts/setup_nextcloud2.sh", args, r, isEnd=True
                            )

                        script_output = self.run_script_in_background(
                            "../scripts/setup_nextcloud.sh",
                            [bdd_password, UserWhoRunTheScript],
                            after,
                        )

                        # Envoyer la sortie du script en temps réel à la réponse HTTP
                        self.wfile.write(
                            bytes('{"status": "OK", "content": ""}', "utf-8")
                        )
                    else:
                        response = "E: Already installed%__NXT_OUT_ERROR__NXT_OUT_%"
                        log("E: Already installed.")
                else:
                    response = "E: WONG apiKey GET param ! %__NXT_OUT_ERROR__NXT_OUT_%"
                    log("E: WONG apiKey GET param ! ")
                self.wfile.write(bytes(response, "utf-8"))
            if self.path.split("?")[0] == "/run_kchat_setup":
                os.system("cp /lnhost/data/kchat.zip ../scripts/kchat.zip")
                flog = open("../logs/http_api.log", "w")
                flog.write("")
                flog.close()
                client_ip = self.client_address[0]
                self.send_response(200)
                self.send_header("Content-type", "text/html")
                self.send_header("Access-Control-Allow-Origin", "*")
                self.end_headers()

                # Extraire le mot de passe de la requête GET
                query_components = parse_qs(urlparse(self.path).query)
                bdd_password = query_components.get("db_password", [""])[0]
                log(str(client_ip) + " is Asking kchat SETUP.")
                kchat_exists = os.path.exists("/home/"+os.getenv("USER")+"/apps/kchat")
                response = ""
                UserWhoRunTheScript = os.getenv("USER")
                f = open("../config/tmp_api.verify")
                tmp = f.read()
                f.close()
                if query_components.get("tmp_api_key", [""])[0] == tmp:
                    if not kchat_exists:
                        log("Executing setup_kchat command." + UserWhoRunTheScript)

                        def after(args):
                            def r(args):
                                pass

                            self.run_script_in_background(
                                "../scripts/setup_kchat2.sh", args, r, isEnd=True
                            )

                        script_output = self.run_script_in_background(
                            "../scripts/setup_kchat.sh",
                            [bdd_password, UserWhoRunTheScript],
                            after,
                        )

                        # Envoyer la sortie du script en temps réel à la réponse HTTP
                        self.wfile.write(
                            bytes('{"status": "OK", "content": ""}', "utf-8")
                        )
                    else:
                        response = "E: Already installed%__NXT_OUT_ERROR__NXT_OUT_%"
                        log("E: Already installed.")
                else:
                    response = "E: WONG apiKey GET param ! %__NXT_OUT_ERROR__NXT_OUT_%"
                    log("E: WONG apiKey GET param ! ")
                self.wfile.write(bytes(response, "utf-8"))
            if self.path.split("?")[0] == "/run_wordpress_setup":
                os.system("cp /lnhost/data/wp.zip ../scripts/wp.zip")
                flog = open("../logs/http_api.log", "w")
                flog.write("")
                flog.close()
                client_ip = self.client_address[0]
                self.send_response(200)
                self.send_header("Content-type", "text/html")
                self.send_header("Access-Control-Allow-Origin", "*")
                self.end_headers()

                # Extraire le mot de passe de la requête GET
                query_components = parse_qs(urlparse(self.path).query)
                bdd_password = query_components.get("db_password", [""])[0]
                log(str(client_ip) + " is Asking wordpress SETUP.")
                wordpress_exists = os.path.exists("/home/"+os.getenv("USER")+"/apps/wordpress")
                response = ""
                UserWhoRunTheScript = os.getenv("USER")
                f = open("../config/tmp_api.verify")
                tmp = f.read()
                f.close()
                if query_components.get("tmp_api_key", [""])[0] == tmp:
                    if not wordpress_exists:
                        log("Executing setup_wordpress command." + UserWhoRunTheScript)

                        def after(args):
                            def r(args):
                                pass

                            self.run_script_in_background(
                                "../scripts/setup_wordpress2.sh", args, r, isEnd=True
                            )

                        script_output = self.run_script_in_background(
                            "../scripts/setup_wordpress.sh",
                            [bdd_password, UserWhoRunTheScript],
                            after,
                        )

                        # Envoyer la sortie du script en temps réel à la réponse HTTP
                        self.wfile.write(
                            bytes('{"status": "OK", "content": ""}', "utf-8")
                        )
                    else:
                        response = "E: Already installed%__NXT_OUT_ERROR__NXT_OUT_%"
                        log("E: Already installed.")
                else:
                    response = "E: WONG apiKey GET param ! %__NXT_OUT_ERROR__NXT_OUT_%"
                    log("E: WONG apiKey GET param ! ")
                self.wfile.write(bytes(response, "utf-8"))
            if self.path.split("?")[0] == "/run_serendipity_setup":
                os.system("cp /lnhost/data/serendipity.zip ../scripts/serendipity.zip")
                flog = open("../logs/http_api.log", "w")
                flog.write("")
                flog.close()
                client_ip = self.client_address[0]
                self.send_response(200)
                self.send_header("Content-type", "text/html")
                self.send_header("Access-Control-Allow-Origin", "*")
                self.end_headers()

                # Extraire le mot de passe de la requête GET
                query_components = parse_qs(urlparse(self.path).query)
                bdd_password = query_components.get("db_password", [""])[0]
                log(str(client_ip) + " is Asking serendipity SETUP.")
                serendipity_exists = os.path.exists("/home/"+os.getenv("USER")+"/apps/serendipity")
                response = ""
                UserWhoRunTheScript = os.getenv("USER")
                f = open("../config/tmp_api.verify")
                tmp = f.read()
                f.close()
                if query_components.get("tmp_api_key", [""])[0] == tmp:
                    if not serendipity_exists:
                        log("Executing setup_serendipity command." + UserWhoRunTheScript)

                        def after(args):
                            def r(args):
                                pass

                            self.run_script_in_background(
                                "../scripts/setup_serendipity2.sh", args, r, isEnd=True
                            )

                        script_output = self.run_script_in_background(
                            "../scripts/setup_serendipity.sh",
                            [bdd_password, UserWhoRunTheScript],
                            after,
                        )

                        # Envoyer la sortie du script en temps réel à la réponse HTTP
                        self.wfile.write(
                            bytes('{"status": "OK", "content": ""}', "utf-8")
                        )
                    else:
                        response = "E: Already installed%__NXT_OUT_ERROR__NXT_OUT_%"
                        log("E: Already installed.")
                else:
                    response = "E: WONG apiKey GET param ! %__NXT_OUT_ERROR__NXT_OUT_%"
                    log("E: WONG apiKey GET param ! ")
                self.wfile.write(bytes(response, "utf-8"))
        except Exception as e:
            try:
                e_traceback = sys.exc_info()[2]
                e_line_number = e_traceback.tb_lineno
                log("E: Exception in python server : " + str(e) + " Line : " + str(e_line_number))
            except Exception as ee:
                log("E: Exception in exception" + str(ee))
    def do_POST(self):
        try:
            content_length = int(self.headers["Content-Length"])
            post_data = self.rfile.read(content_length)
            self.send_response(200)
            self.send_header("Content-type", "text/html")
            self.end_headers()
            fields = parse_qs(str(post_data, "UTF-8"))

            # Obtient l'adresse IP de la personne faisant la requête
            client_ip = self.client_address[0]

            # Log les détails de la requête
            log(f"Received POST request from {client_ip} on path: {self.path}")
            log(f"POST data: {post_data.decode('utf-8')}")

            if "action" in fields and fields["action"][0] == "run_builtInCommand":
                # Log si l'action est 'run_builtInCommand'
                if (
                    fields.get("command")[0] != None
                    and len(fields["command"]) != 1
                    or not isinstance(fields["command"][0], str)
                ):
                    log("E: Bad command parameter.")
                    self.wfile.write(
                        bytes(
                            '{"status": "ERROR", "error": "Invalid command parameter."}',
                            "utf-8",
                        )
                    )
                log("Executing built-in command.")
                if fields.get("APIkey")[0] != api_key:
                    log("W: Invalid API key.")
                    self.wfile.write(
                        bytes(
                            '{"status": "ERROR", "error": "Invalid APIkey parameter."}',
                            "utf-8",
                        )
                    )
                if fields.get("command")[0] == "getStatus":
                    self.wfile.write(
                        bytes('{"status": "OK", "content": "online"}', "utf-8")
                    )
                if fields.get("command")[0] == "appBDD":
                    if fields.get("appName"):
                        app_name = fields["appName"][0]
                        if os.path.exists("../scripts/"+app_name+"BDD.txt"):
                            appBDD_file = open("../scripts/"+app_name+"BDD.txt", "r")
                            appBDD_content = appBDD_file.read().strip()
                            appBDD_file.close()
                            appBDD_separated_line = appBDD_content.splitlines()
                            total_object = {}
                            for line in appBDD_separated_line:
                                line = line.strip()
                                object_name = line.split(":")[0]
                                object_value = ":".join(line.split(":")[1:])
                                if object_name == "ADRESS":
                                    object_value = line.split(":")[0]
                                    object_value = line.split(":")[1]
                                    address_port = line.split(":")[2].split("=")[1]
                                    total_object["MYSQL_PORT"] = address_port
                                total_object[object_name] = object_value
                            self.wfile.write(json.dumps(total_object).encode())
                if fields.get("command")[0] == "getHttpApiLog":
                    f = open("../logs/http_api.log")
                    Clog = f.read()
                    f.close()
                    array = {"status": "OK", "content": Clog}
                    self.wfile.write(
                        bytes(json.dumps(array, ensure_ascii=False), "utf-8")
                    )
                if fields.get("command")[0] == "removeApp":
                    if fields.get("appName")[0] and fields.get("dbPassword")[0]:
                        def r(lolArg):
                            pass
                        self.run_script_in_background(
                        "../scripts/removeBDD.sh", [fields.get("dbPassword")[0], os.getenv("USER"), fields.get("appName")[0], fields.get("appName")[0]+"db"], r, isEnd=True
                        )
                        shutil.rmtree("/home/"+os.getenv("USER")+"/apps/"+fields.get("appName")[0].split("/")[0])
                        array = {"status": "OK", "content": "Your app has been deleted!"}
                        self.wfile.write(
                            bytes(json.dumps(array, ensure_ascii=False), "utf-8")
                        )
                elif fields.get("command")[0] == "getInfos":
                    hostname = socket.gethostname()
                    mypath = app_path
                    onlyfiles = [f for f in listdir(mypath) if isdir(join(mypath, f))]
                    del onlyfiles[onlyfiles.index("lnhost")]
                    infos = {
                        "name": hostname,
                        "server_address": hostName,
                        "apps": onlyfiles,
                    }
                    self.wfile.write(
                        bytes(
                            '{"status": "OK", "content": ' + json.dumps(infos) + "}",
                            "utf-8",
                        )
                    )
        except Exception as e:
            try:
                e_traceback = sys.exc_info()[2]
                e_line_number = e_traceback.tb_lineno
                log(f"E: Exception in python server: {e}, Line: {e_line_number}")
            except Exception as ee:
                log("E: Exception in exception" + str(ee))

    def run_script_in_background(self, script_path, args, callback, isEnd=False):
        script_args = args
        os.chdir("../scripts")
        process = subprocess.Popen(
            script_path + " " + " ".join(script_args),
            stdout=subprocess.PIPE,
            stderr=subprocess.STDOUT,
            universal_newlines=True,
            bufsize=1,
            text=True,
            shell=True,
        )

        # Liste pour stocker la sortie du processus
        output_lines = []

        # Fonction pour lire la sortie du processus en arrière-plan

        def read_output():
            nonlocal output_lines
            while True:
                line = process.stdout.readline()
                if not line:
                    break
                if len(output_lines) > 100:
                    output_lines = ["random_line"]
                output_lines.append(line)
                flog = open("../logs/http_api.log", "w")
                flog.write("\n".join(output_lines))
                flog.close()
                if "XY__SH::EXIT::SH::XY" in line:
                    break
            if isEnd:
                output_lines.append("%__NXT_OUT_stop__NXT_OUT_%")
                flog = open("../logs/http_api.log", "w")
                flog.write("\n".join(output_lines))
                flog.close()
            callback(args)

        # Lancer le thread pour lire la sortie en arrière-plan
        output_thread = threading.Thread(target=read_output)
        output_thread.start()

        return output_lines


if __name__ == "__main__":
    try:
        ip_address = os.popen("hostname -I | awk '{print $1}'").read().strip()
        hostName = "85.2.21.148"
        url = "http://loines.ch/servers/api_port.php"; params = {"u": os.getenv('USER'), "p": open(f"/home/{os.getenv('USER')}/apps/lnhost/config/passwd.lnc", 'r').read().strip()}; serverPort = requests.get(url, params=params).text

        f = open("../config/server_address.lnc", "r")
        contentHost = f.read().strip()
        f.close()
        if (contentHost == "NONE"):
            f2 = open("../config/server_address.lnc", "w")
            f2.write(hostName+":"+str(serverPort))
            f2.close()
        else:
            serverPort = int(contentHost.split(sep=":")[1])
            hostName = contentHost.split(sep=":")[0]
        log("Server address written to ../config/server_address.lnc : http://"+hostName+":"+str(serverPort))
        webServer = HTTPServer((ip_address, serverPort), MyServer)
        log("Server started http://%s:%s" % (ip_address, serverPort))
    except Exception as e:
        try:
            e_traceback = sys.exc_info()[2]
            e_line_number = e_traceback.tb_lineno
            log("E: Exception in starting python server : " + str(e) + " Line : " + str(e_line_number))
        except Exception as ee:
            log("E: Exception in exception" + str(ee))

    try:
        webServer.serve_forever()
    except KeyboardInterrupt as e:
        log("Server stopped")

    webServer.server_close()
    log("Server stopped.")
