from rest_framework import permissions
from rest_framework.decorators import api_view, permission_classes
from .viewsgen import vgen
# Create your views here.
#@csrf_exempt
@api_view(['GET','POST'])
@permission_classes((permissions.AllowAny,))
def mkscorev3(request):
    return vgen.mkscorev3Multiple(request)   
    
@api_view(['GET','POST'])
@permission_classes((permissions.AllowAny,))
def mkscorev4(request):
    return vgen.mkscorev4Multiple(request) 

#@csrf_exempt
@api_view(['GET','POST'])
@permission_classes((permissions.AllowAny,))
def updownload(request):
    return vgen.doUpLoadDown(request)  

#@csrf_exempt
@api_view(['GET','POST'])
@permission_classes((permissions.AllowAny,))
def scoresmail(request):
    return vgen.doSendScoresMail(request)      


"""
#@csrf_exempt
@api_view(['GET','POST'])
@permission_classes((permissions.AllowAny,))
def home(request):
    return vgen.home(request)

@api_view(['POST'])
@permission_classes((permissions.AllowAny,))
def home_io(request):
    return vgen.home_io(request)

@api_view(['POST'])
@permission_classes((permissions.AllowAny,))
def home_iov2(request):
    return vgen.home_iov2(request)

#@csrf_exempt
@api_view(['GET','POST'])
@permission_classes((permissions.AllowAny,))
def mkscorev1(request):
    return vgen.mkscorev1(request)      

#@csrf_exempt
@api_view(['GET','POST'])
@permission_classes((permissions.AllowAny,))
def mkscorev2(request):
    return vgen.mkscorev2(request)   
"""