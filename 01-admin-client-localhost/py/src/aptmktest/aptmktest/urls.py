"""aptmktest URL Configuration

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/3.2/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  path('', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  path('', Home.as_view(), name='home')
Including another URLconf
    1. Import the include() function: from django.urls import include, path
    2. Add a URL to urlpatterns:  path('blog/', include('blog.urls'))
"""
from django.contrib import admin
from django.urls import path
#---------------------------------------------------
from django.urls import include
from django.contrib.auth.models import User
from rest_framework import routers, serializers, viewsets

# Serializers define the API representation.
class UserSerializer(serializers.HyperlinkedModelSerializer):
    class Meta:
        model = User
        fields = ['url', 'username', 'email', 'is_staff']

# ViewSets define the view behavior.
class UserViewSet(viewsets.ModelViewSet):
    queryset = User.objects.all()
    serializer_class = UserSerializer

router = routers.DefaultRouter()
router.register(r'users', UserViewSet)
#---------------------------------------------------
#---------------------------------------------------
from mkapp import views
#---------------------------------------------------
urlpatterns = [
    path('', include(router.urls)),      
    path('mkscorev3', views.mkscorev3, name='mkscorev3'),
    path('mkscorev4', views.mkscorev4, name='mkscorev4'),
    path('updownload', views.updownload, name='updownload'),
    path('scoresmail', views.scoresmail, name='scoresmail'),
    path('admin/', admin.site.urls),
    path('api-auth/', include('rest_framework.urls', namespace='rest_framework')),
]
""" path('home', views.home, name='home'),
    path('homeio', views.home_io, name='home_io'),
    path('homeiov2', views.home_iov2, name='home_iov2'),
    path('mkscorev1', views.mkscorev1, name='mkscorev1'), """  