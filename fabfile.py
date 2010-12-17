from __future__ import with_statement
from fabric.api import *
from fabric.contrib.console import confirm

env.hosts = ['ewb-gt.org']
env.user = 'ewbgtorg'

def prepare_deploy():
  local('tar czf tmp/img.tgz img', capture=False)
  local('tar czf tmp/css.tgz css', capture=False)

def deploy():
  put('tmp/img.tgz', 'tmp/')
  put('tmp/css.tgz', 'tmp/')
  
  with cd('/home/ewbgtorg/'):
    put('cameroon.html', 'public_html')
    put('contact.html', 'public_html')
    put('donate.html', 'public_html')
    put('index.html', 'public_html')
    put('lalima.html', 'public_html')
    put('projects.html', 'public_html')
    run('tar xzf tmp/my_project.tgz')
    
  
