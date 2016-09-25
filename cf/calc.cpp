#include<stdio.h>
#include<stdlib.h>
#include<conio.h>
#include<vector>
#include<string>
#include<cstring>
#include<time.h>
#include<iostream>
#include<set>
#include<thread>
#define c2 c_str()
using namespace std;
char s[100];
int var,ok=0;
pair<int,string> pis;
set<pair<int,string> ,greater<pair<int,string> > >con;
#define MAX_PATH 1000

#include <windows.h>//on windows
std::string getexepath()
{
  char result[ MAX_PATH ];
  string path=string( result, GetModuleFileName( NULL, result, MAX_PATH ) );
  while(path.size()&&path.back()!='/'&&path.back()!='\\'){
    path.pop_back();
  }
  return path;

}
/*
#include <limits.h>
#include <unistd.h>
std::string getexepath()//on linux
{
  char result[ PATH_MAX ];
  ssize_t count = readlink( "/proc/self/exe", result, PATH_MAX );
  return std::string( result, (count > 0) ? count : 0 );
}
*/




int main()
{

    string DIR=getexepath();
    FILE *f;
    //time
    f=fopen((DIR+"f/time.txt").c2,"r");
    time_t pst=0,tm=time(0);
    fscanf(f,"%d",&pst);
    fclose(f);
    cout<<tm<<" "<<pst<<endl;
    if(tm<pst) return 0;
    fopen((DIR+"f/time.txt").c2,"w");
    fprintf(f,"%d",(tm+60*5));
    fclose(f);

    //fetch&execute
    vector<string> handles;
    system(("C://xampp/php/php.exe "+DIR+"getUsers.php").c2);
    f=fopen((DIR+"f/users.txt").c2,"r");
    if(f==NULL)puts("what!!C++");
    while(fgets(s,100,f)) handles.push_back(s);
    fclose(f);
    for(int i=0;i<handles.size();i++){
        f=fopen((DIR+"f/users.txt").c2,"w");
        fprintf(f,"%s\n",handles[i].c_str());
        fclose(f);
        printf("\nreturned= %d \n\n",system(("C://xampp/php/php.exe "+DIR+"calculate.php").c2));///////////// should implement more relaiable execution with thread!!

        //if the api query ok. check status in msg.txt.
        f=fopen((DIR+"f/msg.txt").c2,"r");
        fscanf(f,"%s",&s);
        fclose(f);
        if(!strcmp(s,"OK"))
            ok++;
        else{
            fscanf(f,"%s",&s);
            cout<<s<<" CMNT "<<handles[i]<<endl;
            if(strstr(s,"Call limit exceeded")){
                i--;
                Sleep(500); //linux equ
            }
        }

        ////contest list
        FILE *cif=fopen((DIR+"f/ti.txt").c2,"r"),*cnf=fopen((DIR+"f/tn.txt").c2,"r");

        while(fscanf(cif,"%d",&var)!=EOF){
            fgets(s,100,cnf);
            con.insert({var,s});
        }
    }

    cout<<con.size()<<endl;
   // getch();
    if(ok<handles.size())return 1;

    f=fopen((DIR+"f/time.txt").c2,"w");
    fprintf(f,"%d",(time(0)+3600*2));
    fclose(f);

    FILE *cif=fopen((DIR+"f/conid.txt").c2,"w"),*cnf=fopen((DIR+"f/conname.txt").c2,"w");
    for(auto &v:con)
    {
        fprintf(cif,"%d\n",v.first);
        fprintf(cnf,"%s",v.second.c_str());
    }
    fclose(cif);
    fclose(cnf);

    return 0;
}

