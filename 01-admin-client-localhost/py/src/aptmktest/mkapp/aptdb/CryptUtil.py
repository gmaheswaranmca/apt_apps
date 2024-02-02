#pip install cryptocode
import cryptocode
''' 
    encoded = cryptocode.encrypt("mystring","mypassword")
    print(encoded,end='\n\n')
    ## And then to decode it:
    decoded = cryptocode.decrypt(encoded, "mypassword")
    print(decoded,end='\n\n')
'''
class Crypt: #str_key = 'muralidaran2010&viji1984=>maheswaran1979"
    def __init__(self):
        pass

    def encrypt(self, str_to_enc, str_key):
        return cryptocode.encrypt(str_to_enc,str_key)

    def decrypt(self, enc_str, str_key):
        return cryptocode.decrypt(enc_str,str_key)
    
    def getMailPassword(self, crytoPwd):
        str_key = 'muralidaran2010&viji1984=maheswaran1979'
        return self.decrypt(crytoPwd, str_key)
    
    def getCryptoPassword(self, pwd):
        str_key = 'muralidaran2010&viji1984=maheswaran1979'
        return self.encrypt(pwd, str_key)
    
cryto = Crypt()     